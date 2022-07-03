<?php

namespace App\Http\Controllers;

class VideoStreamController
{
    private mixed $stream = '';
    private int $buffer = 102400;
    private int $start = -1;
    private int $end = -1;
    private int $size = 0;

    public function __construct(protected string $path)
    {
    }

    /**
     * Start streaming video content.
     */
    public function start(): void
    {
        $this->open();
        $this->setHeader();
        $this->stream();
        $this->end();
    }

    /**
     * Open stream.
     */
    private function open(): void
    {
        if (! ($this->stream = fopen($this->path, 'rb'))) {
            die('Could not open stream for reading');
        }
    }

    /**
     * Set proper header to serve the video content.
     */
    private function setHeader(): void
    {
        ob_get_clean();
        header('Content-Type: video/mp4');
        header('Cache-Control: max-age=2592000, public');
        header('Expires: '.gmdate('D, d M Y H:i:s', time() + 2592000).' GMT');
        header('Last-Modified: '.gmdate('D, d M Y H:i:s', @filemtime($this->path)).' GMT');
        $this->start = 0;
        $this->size = filesize($this->path);
        $this->end = $this->size - 1;
        header('Accept-Ranges: 0-'.$this->end);

        if (isset($_SERVER['HTTP_RANGE'])) {
            $c_end = $this->end;

            [, $range] = explode('=', $_SERVER['HTTP_RANGE'], 2);

            if (mb_strpos($range, ',') !== false) {
                header('HTTP/1.1 416 Requested Range Not Satisfiable');
                header("Content-Range: bytes {$this->start}-{$this->end}/{$this->size}");
                exit;
            }

            if ($range === '-') {
                $c_start = $this->size - mb_substr($range, 1);
            } else {
                $range = explode('-', $range);
                $c_start = $range[0];

                $c_end = isset($range[1]) && is_numeric($range[1]) ? $range[1] : $c_end;
            }
            $c_end = min($c_end, $this->end);

            if ($c_start > $c_end || $c_start > $this->size - 1 || $c_end >= $this->size) {
                header('HTTP/1.1 416 Requested Range Not Satisfiable');
                header("Content-Range: bytes {$this->start}-{$this->end}/{$this->size}");
                exit;
            }
            $this->start = $c_start;
            $this->end = $c_end;
            $length = $this->end - $this->start + 1;
            fseek($this->stream, $this->start);
            header('HTTP/1.1 206 Partial Content');
            header('Content-Length: '.$length);
            header("Content-Range: bytes {$this->start}-{$this->end}/".$this->size);
        } else {
            header('Content-Length: '.$this->size);
        }
    }

    /**
     * close curretly opened stream.
     */
    private function end(): void
    {
        fclose($this->stream);
        exit;
    }

    /**
     * perform the streaming of calculated range.
     */
    private function stream(): void
    {
        $i = $this->start;
        set_time_limit(0);
        while (! feof($this->stream) && $i <= $this->end) {
            $bytesToRead = $this->buffer;

            if ($i + $bytesToRead > $this->end) {
                $bytesToRead = $this->end - $i + 1;
            }
            $data = fread($this->stream, $bytesToRead);
            echo $data;
            flush();
            $i += $bytesToRead;
        }
    }
}

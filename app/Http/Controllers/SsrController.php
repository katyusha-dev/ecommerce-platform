<?php

namespace App\Http\Controllers;

use Features\Request\SsrPageContext;
use Illuminate\Http\Request;
use Katyusha\Ssr\Facades\Ssr;
use Katyusha\Ssr\Renderer;
use function view;

class SsrController extends Controller
{
    protected Renderer $renderer;

    public function __construct()
    {
        $this->renderer = Ssr::entry('build/server.js');
    }

    public function index(Request $request)
    {
        return $this->output($request);
    }

    public function context(Request $request)
    {
        $context = new SsrPageContext($request);
        $res = [];
        foreach ($context->get() as $k => $v) {
            $res[$k] = $v;
        }

        return $res;
    }

    protected function output(Request $request)
    {
        $context = new SsrPageContext($request);

        foreach ($context->get() as $k => $v) {
            $this->renderer->context($k, $v);
        }

        $output = $this->renderer->render();

        return view('ssr.index', ['ssrOutput' => $output, 'context' => $context->get()]);
    }
}

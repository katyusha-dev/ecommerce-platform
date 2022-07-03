<?php
/** @var string $ssrOutput */
/** @var array $context */
?>

<html>

<head>
    <link href="/scss/stylesheets.css" rel="stylesheet"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
<div class="container">
    <div id="app">{!! $ssrOutput !!}</div>
</div>
<script>

  let context = {!! str_replace("'", "\'", json_encode($context)) !!}
</script>
<script src="/build/client.js"></script>
</body>


</html>
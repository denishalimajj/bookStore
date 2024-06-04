<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Swagger UI</title>
    <link href="{{ asset('vendor/swagger-ui/dist/swagger-ui.css') }}" rel="stylesheet">
    <style>
        html {
            box-sizing: border-box;
            overflow-y: scroll;
        }
        *, *:before, *:after {
            box-sizing: inherit;
        }

        body {
            margin: 0;
            background: #fafafa;
        }
    </style>
</head>
<body>
<div id="swagger-ui"></div>
<script src="{{ asset('vendor/swagger-ui/dist/swagger-ui-bundle.js') }}"></script>
<script src="{{ asset('vendor/swagger-ui/dist/swagger-ui-standalone-preset.js') }}"></script>
<script>
    window.onload = function() {
        const ui = SwaggerUIBundle({
            url: "{{ asset('docs/openapi.json') }}",
            dom_id: '#swagger-ui',
            presets: [
                SwaggerUIBundle.presets.apis,
                SwaggerUIStandalonePreset
            ],
            layout: "StandaloneLayout"
        });

        window.ui = ui;
    }
</script>
</body>
</html>

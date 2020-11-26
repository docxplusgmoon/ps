<html>
<head>
    <title>App Name - @yield('title')</title>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>@yield('title')</h1>
    </div>
    <div class="content">
        @yield('content')
    </div>
</div>

<style>
    html, body {
        background: #f6f6f6;
        margin: 0;
    }

    * {
        box-sizing: border-box;
    }

    .container {
        background: #fff;
        max-width: 1280px;
        margin: 0 auto;
    }

    .header {
        padding: 15px;
        border-bottom: 2px solid #f6f6f6;
    }

    .content {
        padding: 15px;
    }
    table.user_report {
        width: 100%;
        border-spacing: 0px;
        border-collapse: collapse;
    }
    table.user_report td, table.user_report th {
        padding: 5px;
        text-align: right;
        border: 1px solid #ddd;
    }

    .totals {
        margin: 20px 0;
    }

    .totals div {
        padding: 7px;
    }
    .form input {
        padding: 5px;
        outline: none;
        border: 1px solid #b6b6b6;
    }
    .form input[type="submit"] {
        cursor: pointer;
        width: 125px;
        padding: 7px;
        background: #bbb;
    }
    .pages a, .pages span {
        display: inline-block;
        padding: 5px;
        color: #4b4b6e;
        border: 1px solid #ddd;
        text-decoration: none;
        background: #fff;
        border-radius: 2px;
        font-size: 14px;
    }
    .pages {
        padding: 25px;
        text-align: right;
    }
</style>
</body>
</html>

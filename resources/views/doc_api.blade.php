<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.87.0">
    <title>REST API - CF3J 2021</title>
    <link rel="stylesheet" href="{{ asset('/css/dashboard.css') }}" media="all" />
    <link rel="stylesheet" href="{{ asset('/css/bootstrap.min.css') }}" media="all" />
    <style>
        html {
            font-size: 14px !important
        }
        pre {
            background-color: #f6f8fa;
            color: #24292f
            display: block;
            font-family: ui-monospace,SFMono-Regular,SF Mono,Menlo,Consolas,Liberation Mono,monospace;
            white-space: pre;
            border-radius: 6px;
    font-size: 14px !important;
    line-height: 1.45;
            max-width: 100%;
            padding: 15px !important; 
            overflow: auto;
            width: 100%;
            margin-bottom: 0;
    word-break: normal
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar pt-3 collapse">
                <div class="position-sticky  ">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">
                                <span data-feather="home"></span>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#api2">
                                <span data-feather="file"></span>
                                Orders API 2
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="shopping-cart"></span>
                                Products
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="users"></span>
                                Customers
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="bar-chart-2"></span>
                                Reports
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="layers"></span>
                                Integrations
                            </a>
                        </li>
                    </ul>
                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Saved reports</span>
                        <a class="link-secondary" href="#" aria-label="Add a new report">
                            <span data-feather="plus-circle"></span>
                        </a>
                    </h6>
                    <ul class="nav flex-column mb-2">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="file-text"></span>
                                Current month
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="file-text"></span>
                                Last quarter
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="file-text"></span>
                                Social engagement
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="file-text"></span>
                                Year-end sale
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 p-3">
                <h1>Get started with API-CF3J v2.1.15</h1>
                <pre>
HTTP/1.1 401 Unauthorized
Server: My RESTful API
Content-Type: application/json
Content-Length: xy
    {
    "code": 120,
    "message": "invalid crendetials",
    "resolve": "The username or password is not correct."
    }  </pre>
                <p class="fs-5 col-md-8">Quickly and easily get started with Bootstrap's compiled, production-ready files with this barebones example featuring some basic HTML and helpful links. Download all our examples to get started.</p>
                <div class="mb-5">
                    <a href="../examples/" class="btn btn-primary btn-lg px-4">Download examples</a>
                </div>
                <hr class="col-3 col-md-2 mb-5">
                <div class="row g-5">
                    <div class="col-md-6">
                        <h2>Starter projects</h2>
                        <p>Ready to beyond the starter template? Check out these open source projects that you can quickly duplicate to a new GitHub repository.</p>
                        <ul class="icon-list">
                            <li><a href="https://github.com/twbs/bootstrap-npm-starter" rel="noopener" target="_blank">Bootstrap npm starter</a></li>
                            <li class="text-muted">Bootstrap Parcel starter (coming soon!)</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h2>Guides</h2>
                        <p>Read more detailed instructions and documentation on using or contributing to Bootstrap.</p>
                        <ul class="icon-list">
                            <li><a href="../getting-started/introduction/">Bootstrap quick start guide</a></li>
                            <li><a href="../getting-started/webpack/">Bootstrap Webpack guide</a></li>
                            <li><a href="../getting-started/parcel/">Bootstrap Parcel guide</a></li>
                            <li><a href="../getting-started/contribute/">Contributing to Bootstrap</a></li>
                        </ul>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>

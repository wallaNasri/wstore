<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-UA-compatible" content="IE=edge">
    <title>{{config('app.name')}}</title>
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    @yield('css')
</head>

<body>
    <header class="py-2 bg-dark text-white mb-4">
        <div class="container">
            <div class="d-flex">
                <h1 class="h3">{{config('app.name')}}</h1>
                @auth
                <div class="ms-auto">
                    Hi, {{Auth::user()->name}}
                    <a href="#" onclick="document.getElementById('logout').submit()">Logout</a>
                    <form id="logout" class="d-none" action="{{route('logout')}} " method="POST">
                    @csrf
                    </form>
                </div>
                @endauth
            </div>
        </div>
    </header>

    <div class="container">
        <div class="row">
            <aside class="col-md-3">
                <h4>Navigation Menu</h4>
                <nav>
                    <ul class="nav nav-pills flex-column">



                        <li class="nav-item"><a href="{{route('dashboard')}}" class="nav-link  @if(request()->routeIs('dashboard')) active @endif">Dashboard</a></li>
                        <li class="nav-item"><a href="{{route('admin.categories.index')}}" class="nav-link  @if(request()->routeIs('admin.categories.*')) active @endif">Categories</a></li>

                        <li class="nav-item"><a href="{{route('products.index')}}" class="nav-link @if(request()->routeIs('products.*')) active @endif ">Product</a></li>



                    </ul>
                </nav>

            </aside>
            <main class="col-md-9">
                <h2 class="mb-4"> @yield('title')</h2>


                @yield('content')

            </main>

        </div>


    </div>
    <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
    @yield('js')
</body>

</html>
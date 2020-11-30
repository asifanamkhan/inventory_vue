<!DOCTYPE html>
<html lang="en">

<head>
@include('layouts.head')
</head>

<body class="">
<div class="wrapper" id="app">

    <sidebar></sidebar>

    <div class="main-panel">

        <nav-top></nav-top>

        <div class="content">
            <div class="container-fluid">
                <router-view></router-view>
                @yield('content')
            </div>
        </div>


        <footer-bottom></footer-bottom>
    </div>
    <sidebar-filter></sidebar-filter>
</div>

@include('layouts.script')
</body>

</html>
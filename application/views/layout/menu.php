<header>
    <div>
    <nav class="nav nav-masthead justify-content-center float-md-end">
        <a href="/"><img id="logo" src="/assets/img/logo.jpg"></a>
        <a href="/" class="nav-link <?php if($this->router->fetch_class() == "main") echo "active";?>" href="/">Home</a>
        <a href="/index.php/notice/list" class="nav-link <?php if($this->router->fetch_class() == "notice") echo "active";?>" href="#">공지사항</a>
        <a href="/index.php/login" class="nav-link <?php if($this->router->fetch_class() == "login") echo "active";?>" href="/login">로그인</a>
    </nav>
    </div>
</header>
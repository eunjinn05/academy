<header>
    <div>
    <nav class="nav nav-masthead justify-content-center float-md-end">
        <a href="/"><img id="logo" src="/assets/img/logo.jpg"></a>
        <a href="/" class="nav-link <?php if($this->router->fetch_class() == "main") echo "active";?>">Home</a>
        <a href="/index.php/notice/list" class="nav-link <?php if($this->router->fetch_class() == "notice") echo "active";?>">공지사항</a>
        <?php if (@$_SESSION['admin']) { ?>
            <a href="/index.php/login/logout_exec" class="nav-link <?php if($this->router->fetch_class() == "login") echo "active";?>">로그아웃</a>
        <?php } else { ?>
            <a href="/index.php/login" class="nav-link <?php if($this->router->fetch_class() == "login") echo "active";?>">로그인</a>
        <?php } ?>
    </nav>
    </div>
</header>
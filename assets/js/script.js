window.addEventListener('turbo:load', function () {
    initToolbar();
});

function initToolbar() {
    document.getElementById("sidebarToggle").addEventListener("click", function () {
        document.body.classList.toggle('sb-sidenav-toggled');
        localStorage.setItem('sidebar', document.body.classList.contains('sb-sidenav-toggled') ? 'true' : 'false');
    })

    document.getElementById("layoutSidenav_content").addEventListener("click", function () {
        collapseSidebar()
    })

    document.querySelector('nav').addEventListener("click", function (e) {
        if (!e.target.closest("#sidebarToggle")) {
            collapseSidebar()
        }
    })
}

function collapseSidebar () {
    if (document.querySelector('nav.navbar').offsetWidth >= 992) {
        document.body.classList.add('sb-sidenav-toggled');
    }
    else {
        document.body.classList.remove('sb-sidenav-toggled');
    }
    localStorage.setItem('sidebar', document.body.classList.contains('sb-sidenav-toggled') ? 'true' : 'false');
}
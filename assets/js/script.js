/*!
    * Start Bootstrap - SB Admin v7.0.7 (https://startbootstrap.com/template/sb-admin)
    * Copyright 2013-2023 Start Bootstrap
    * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin/blob/master/LICENSE)
    */
    // 
// Scripts
// 

let source = false, target = false;

window.addEventListener('DOMContentLoaded', function () {
    initToolbar();
});

window.addEventListener('turbo:render', function () {
    initToolbar();
});

function initToolbar() {
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        //     document.body.classList.toggle('sb-sidenav-toggled');
        // }
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
        });

        document.getElementById("layoutSidenav_content").addEventListener('click', () => {
            document.body.classList.add('sb-sidenav-toggled');
        });
    }
}
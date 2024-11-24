/*
Template Name: Doot - Responsive Bootstrap 5 Chat App
Author: Themesbrand
Version: 1.3.0
Website: https://Themesbrand.com/
Contact: Themesbrand@gmail.com
File: Main Js File
*/


(function () {

        'use strict';

        function initComponents() {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                        return new bootstrap.Tooltip(tooltipTriggerEl)
                })

                var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
                var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
                        return new bootstrap.Popover(popoverTriggerEl)
                })
        }

        function initSettings() {
                var body = document.getElementsByTagName("body")[0];
                var lightDarkBtn = document.querySelectorAll('.light-dark')
                if (lightDarkBtn) {
                        lightDarkBtn.forEach(function (item) {
                                item.addEventListener('click', function (event) {
                                        if (body.hasAttribute("data-bs-theme") && body.getAttribute("data-bs-theme") == "dark") {
                                                document.body.setAttribute('data-bs-theme', 'light');
                                        } else {
                                                document.body.setAttribute('data-bs-theme', 'dark');
                                        }
                                });
                        });
                }

        }

        function init() {
                initComponents();
                initSettings();
                Waves.init();
        }

        init();

})();
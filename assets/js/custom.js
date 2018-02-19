/*jslint browser: true*/
/*global $, jQuery, alert*/

$(document).ready(function () {

    "use strict";

    var body = $("body");

    $(function () {
        $(".preloader").fadeOut();
        $('#side-menu').metisMenu();
    });

    /* ===== Theme Settings ===== */

    $(".open-close").on("click", function () {
        body.toggleClass("show-sidebar").toggleClass("hide-sidebar");
        $(".sidebar-head .open-close i").toggleClass("ti-menu");
    });

    /* ===== Open-Close Right Sidebar ===== */

    $(".right-side-toggle").on("click", function () {
        $(".right-sidebar").slideDown(50).toggleClass("shw-rside");
        $(".fxhdr").on("click", function () {
            body.toggleClass("fix-header"); /* Fix Header JS */
        });
        $(".fxsdr").on("click", function () {
            body.toggleClass("fix-sidebar"); /* Fix Sidebar JS */
        });

        /* ===== Service Panel JS ===== */

        var fxhdr = $('.fxhdr');
        if (body.hasClass("fix-header")) {
            fxhdr.attr('checked', true);
        } else {
            fxhdr.attr('checked', false);
        }
    });

    /* ===========================================================
        Loads the correct sidebar on window load.
        collapses the sidebar on window resize.
        Sets the min-height of #page-wrapper to window size.
    =========================================================== */

    $(function () {
        var set = function () {
                var topOffset = 60,
                    width = (window.innerWidth > 0) ? window.innerWidth : this.screen.width,
                    height = ((window.innerHeight > 0) ? window.innerHeight : this.screen.height) - 1;
                if (width < 768) {
                    $('div.navbar-collapse').addClass('collapse');
                    topOffset = 100; /* 2-row-menu */
                } else {
                    $('div.navbar-collapse').removeClass('collapse');
                }

                /* ===== This is for resizing window ===== */

                if (width < 1170) {
                    body.addClass('content-wrapper');
                    $(".sidebar-nav, .slimScrollDiv").css("overflow-x", "visible").parent().css("overflow", "visible");
                } else {
                    body.removeClass('content-wrapper');
                }

                height = height - topOffset;
                if (height < 1) {
                    height = 1;
                }
                if (height > topOffset) {
                    $("#page-wrapper").css("min-height", (height) + "px");
                }
            }
        //     url = window.location,
        //     element = $('ul.nav a').filter(function () {
        //         return this.href === url || url.href.indexOf(this.href) === 0;
        //     }).addClass('active').parent().parent().addClass('in').parent();
        // if (element.is('li')) {
        //     element.addClass('active');
        // }
        $(window).ready(set);
        $(window).bind("resize", set);

        if(jQuery.isEmptyObject(urlParams)){
            $('.menu-beranda').addClass('active');
            $('.menu-beranda').find('a').first().addClass('active');
        }
        else{
            switch(urlParams.m.toLowerCase()){
                // menu data karyawan
                case "pekerjaan":
                    $('.menu-data-master').addClass('active');
                    $('.menu-data-master').find('a').first().addClass('active');
                    $('.menu-data-master').find('ul').first().addClass('in');
                    $('.menu-data-pekerjaan').addClass('active');
                    $('.menu-data-pekerjaan').find('a').first().addClass('active');
                    break;

                // menu data karyawan
                case "karyawan":
                    $('.menu-data-master').addClass('active');
                    $('.menu-data-master').find('a').first().addClass('active');
                    $('.menu-data-master').find('ul').first().addClass('in');
                    $('.menu-data-karyawan').addClass('active');
                    $('.menu-data-karyawan').find('a').first().addClass('active');
                    break;

                // menu data supplier
                case "supplier":
                    $('.menu-data-master').addClass('active');
                    $('.menu-data-master').find('a').first().addClass('active');
                    $('.menu-data-master').find('ul').first().addClass('in');
                    $('.menu-data-supplier').addClass('active');
                    $('.menu-data-supplier').find('a').first().addClass('active');
                    break;

                // menu data buyer
                case "buyer":
                    $('.menu-data-master').addClass('active');
                    $('.menu-data-master').find('a').first().addClass('active');
                    $('.menu-data-master').find('ul').first().addClass('in');
                    $('.menu-data-buyer').addClass('active');
                    $('.menu-data-buyer').find('a').first().addClass('active');
                    break;

                // menu data bahan baku
                case "bahan_baku":
                    $('.menu-data-master').addClass('active');
                    $('.menu-data-master').find('a').first().addClass('active');
                    $('.menu-data-master').find('ul').first().addClass('in');
                    $('.menu-data-bahan-baku').addClass('active');
                    $('.menu-data-bahan-baku').find('a').first().addClass('active');
                    break;

                // menu data produk
                case "produk":
                    $('.menu-data-master').addClass('active');
                    $('.menu-data-master').find('a').first().addClass('active');
                    $('.menu-data-master').find('ul').first().addClass('in');
                    $('.menu-data-produk').addClass('active');
                    $('.menu-data-produk').find('a').first().addClass('active');
                    break;

                // menu data harga basis
                case "harga_basis":
                    $('.menu-data-master').addClass('active');
                    $('.menu-data-master').find('a').first().addClass('active');
                    $('.menu-data-master').find('ul').first().addClass('in');
                    $('.menu-data-harga-basis').addClass('active');
                    $('.menu-data-harga-basis').find('a').first().addClass('active');
                    break;

                // menu data kendaraan
                case "kendaraan":
                    $('.menu-data-master').addClass('active');
                    $('.menu-data-master').find('a').first().addClass('active');
                    $('.menu-data-master').find('ul').first().addClass('in');
                    $('.menu-data-kendaraan').addClass('active');
                    $('.menu-data-kendaraan').find('a').first().addClass('active');
                    break;

                // menu data user
                case "user":
                    $('.menu-data-master').addClass('active');
                    $('.menu-data-master').find('a').first().addClass('active');
                    $('.menu-data-master').find('ul').first().addClass('in');
                    $('.menu-data-user').addClass('active');
                    $('.menu-data-user').find('a').first().addClass('active');
                    break;

                // menu data kir
                case "kir":
                    $('.menu-data-kir').addClass('active');
                    $('.menu-data-kir').find('a').first().addClass('active');
                    break;

                // menu data analisa harga
                case "analisa_harga":
                    $('.menu-data-analisa-harga').addClass('active');
                    $('.menu-data-analisa-harga').find('a').first().addClass('active');
                    break;

                // menu data pembelian
                case "pembelian":
                    $('.menu-data-pembelian').addClass('active');
                    $('.menu-data-pembelian').find('a').first().addClass('active');
                    break;

                // menu data pemesanan
                case "pemesanan":
                    $('.menu-data-pemesanan').addClass('active');
                    $('.menu-data-pemesanan').find('a').first().addClass('active');
                    break;

                // menu data pengiriman
                case "pengiriman":
                    $('.menu-data-pengiriman').addClass('active');
                    $('.menu-data-pengiriman').find('a').first().addClass('active');
                    break;

                // menu data perencanaan bahan baku
                case "perencanaan_bahan_baku":
                    $('.menu-data-perencanaan-bahan-baku').addClass('active');
                    $('.menu-data-perencanaan-bahan-baku').find('a').first().addClass('active');
                    break;

                // menu data stok bahan baku
                case "stok_bahan_baku":
                    $('.menu-data-monitoring-persediaan').addClass('active');
                    $('.menu-data-monitoring-persediaan').find('a').first().addClass('active');
                    $('.menu-data-monitoring-persediaan').find('ul').first().addClass('in');
                    $('.menu-data-stok-bahan-baku').addClass('active');
                    $('.menu-data-stok-bahan-baku').find('a').first().addClass('active');
                    break;

                // menu data stok produk
                case "stok_produk":
                    $('.menu-data-monitoring-persediaan').addClass('active');
                    $('.menu-data-monitoring-persediaan').find('a').first().addClass('active');
                    $('.menu-data-monitoring-persediaan').find('ul').first().addClass('in');
                    $('.menu-data-stok-produk').addClass('active');
                    $('.menu-data-stok-produk').find('a').first().addClass('active');
                    break;

                 // menu data mutasi bahan baku
                case "mutasi_bahan_baku":
                    $('.menu-data-monitoring-persediaan').addClass('active');
                    $('.menu-data-monitoring-persediaan').find('a').first().addClass('active');
                    $('.menu-data-monitoring-persediaan').find('ul').first().addClass('in');
                    $('.menu-data-mutasi-bahan-baku').addClass('active');
                    $('.menu-data-mutasi-bahan-baku').find('a').first().addClass('active');
                    break;

                 // menu data mutasi produk
                case "mutasi_produk":
                    $('.menu-data-monitoring-persediaan').addClass('active');
                    $('.menu-data-monitoring-persediaan').find('a').first().addClass('active');
                    $('.menu-data-monitoring-persediaan').find('ul').first().addClass('in');
                    $('.menu-data-mutasi-produk').addClass('active');
                    $('.menu-data-mutasi-produk').find('a').first().addClass('active');
                    break;

                // menu data produksi
                case "produksi":
                    $('.menu-data-produksi').addClass('active');
                    $('.menu-data-produksi').find('a').first().addClass('active');
                    break;

                // default menu beranda
                default:
                    $('.menu-beranda').addClass('active');
                    $('.menu-beranda').find('a').first().addClass('active');
                    break;
            }
        }
    });

    /* ===== Collapsible Panels JS ===== */

    (function ($, window, document) {
        var panelSelector = '[data-perform="panel-collapse"]',
            panelRemover = '[data-perform="panel-dismiss"]';
        $(panelSelector).each(function () {
            var collapseOpts = {
                    toggle: false
                },
                parent = $(this).closest('.panel'),
                wrapper = parent.find('.panel-wrapper'),
                child = $(this).children('i');
            if (!wrapper.length) {
                wrapper = parent.children('.panel-heading').nextAll().wrapAll('<div/>').parent().addClass('panel-wrapper');
                collapseOpts = {};
            }
            wrapper.collapse(collapseOpts).on('hide.bs.collapse', function () {
                child.removeClass('ti-minus').addClass('ti-plus');
            }).on('show.bs.collapse', function () {
                child.removeClass('ti-plus').addClass('ti-minus');
            });
        });

        /* ===== Collapse Panels ===== */

        $(document).on('click', panelSelector, function (e) {
            e.preventDefault();
            var parent = $(this).closest('.panel'),
                wrapper = parent.find('.panel-wrapper');
            wrapper.collapse('toggle');
        });

        /* ===== Remove Panels ===== */

        $(document).on('click', panelRemover, function (e) {
            e.preventDefault();
            var removeParent = $(this).closest('.panel');

            function removeElement() {
                var col = removeParent.parent();
                removeParent.remove();
                col.filter(function () {
                    return ($(this).is('[class*="col-"]') && $(this).children('*').length === 0);
                }).remove();
            }
            removeElement();
        });
    }(jQuery, window, document));

    /* ===== Tooltip Initialization ===== */

    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

    /* ===== Popover Initialization ===== */

    $(function () {
        $('[data-toggle="popover"]').popover();
    });

    /* ===== Task Initialization ===== */

    $(".list-task li label").on("click", function () {
        $(this).toggleClass("task-done");
    });
    $(".settings_box a").on("click", function () {
        $("ul.theme_color").toggleClass("theme_block");
    });

    /* ===== Collepsible Toggle ===== */

    $(".collapseble").on("click", function () {
        $(".collapseblebox").fadeToggle(350);
    });

    /* ===== Sidebar ===== */

    $('.slimscrollright').slimScroll({
        height: '100%',
        position: 'right',
        size: "5px",
        color: '#dcdcdc'
    });
    $('.slimscrollsidebar').slimScroll({
        height: '100%',
        position: 'right',
        size: "6px",
        color: 'rgba(0,0,0,0.3)'
    });
    $('.chat-list').slimScroll({
        height: '100%',
        position: 'right',
        size: "0px",
        color: '#dcdcdc'
    });

    /* ===== Resize all elements ===== */

    body.trigger("resize");

    /* ===== Visited ul li ===== */

    $('.visited li a').on("click", function (e) {
        $('.visited li').removeClass('active');
        var $parent = $(this).parent();
        if (!$parent.hasClass('active')) {
            $parent.addClass('active');
        }
        e.preventDefault();
    });

    /* ===== Login and Recover Password ===== */

    $('#to-recover').on("click", function () {
        $("#loginform").slideUp();
        $("#recoverform").fadeIn();
    });

    /* ================================================================= 
        Update 1.5
        this is for close icon when navigation open in mobile view
    ================================================================= */

    $(".navbar-toggle").on("click", function () {
        $(".navbar-toggle i").toggleClass("ti-menu").addClass("ti-close");
    });
});

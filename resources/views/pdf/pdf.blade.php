<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        /*!
         * Bootstrap v3.3.7 (http://getbootstrap.com)
         * Copyright 2011-2016 Twitter, Inc.
         * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
         */

        .container {
            margin-right: auto;
            margin-left: auto;
            padding-left: 15px;
            padding-right: 15px;
        }
        @media (min-width: 768px) {
            .container {
                width: 750px;
            }
        }
        @media (min-width: 992px) {
            .container {
                width: 970px;
            }
        }
        @media (min-width: 1200px) {
            .container {
                width: 1170px;
            }
        }
        .container-fluid {
            margin-right: auto;
            margin-left: auto;
            padding-left: 15px;
            padding-right: 15px;
        }
        .row {
            margin-left: -15px;
            margin-right: -15px;
        }
        .col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 {
            position: relative;
            min-height: 1px;
            padding-left: 15px;
            padding-right: 15px;
        }
        .col-xs-1, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9, .col-xs-10, .col-xs-11, .col-xs-12 {
            float: left;
        }
        .col-xs-12 {
            width: 100%;
        }
        .col-xs-11 {
            width: 91.66666667%;
        }
        .col-xs-10 {
            width: 83.33333333%;
        }
        .col-xs-9 {
            width: 75%;
        }
        .col-xs-8 {
            width: 66.66666667%;
        }
        .col-xs-7 {
            width: 58.33333333%;
        }
        .col-xs-6 {
            width: 50%;
        }
        .col-xs-5 {
            width: 41.66666667%;
        }
        .col-xs-4 {
            width: 33.33333333%;
        }
        .col-xs-3 {
            width: 25%;
        }
        .col-xs-2 {
            width: 16.66666667%;
        }
        .col-xs-1 {
            width: 8.33333333%;
        }
        .col-xs-pull-12 {
            right: 100%;
        }
        .col-xs-pull-11 {
            right: 91.66666667%;
        }
        .col-xs-pull-10 {
            right: 83.33333333%;
        }
        .col-xs-pull-9 {
            right: 75%;
        }
        .col-xs-pull-8 {
            right: 66.66666667%;
        }
        .col-xs-pull-7 {
            right: 58.33333333%;
        }
        .col-xs-pull-6 {
            right: 50%;
        }
        .col-xs-pull-5 {
            right: 41.66666667%;
        }
        .col-xs-pull-4 {
            right: 33.33333333%;
        }
        .col-xs-pull-3 {
            right: 25%;
        }
        .col-xs-pull-2 {
            right: 16.66666667%;
        }
        .col-xs-pull-1 {
            right: 8.33333333%;
        }
        .col-xs-pull-0 {
            right: auto;
        }
        .col-xs-push-12 {
            left: 100%;
        }
        .col-xs-push-11 {
            left: 91.66666667%;
        }
        .col-xs-push-10 {
            left: 83.33333333%;
        }
        .col-xs-push-9 {
            left: 75%;
        }
        .col-xs-push-8 {
            left: 66.66666667%;
        }
        .col-xs-push-7 {
            left: 58.33333333%;
        }
        .col-xs-push-6 {
            left: 50%;
        }
        .col-xs-push-5 {
            left: 41.66666667%;
        }
        .col-xs-push-4 {
            left: 33.33333333%;
        }
        .col-xs-push-3 {
            left: 25%;
        }
        .col-xs-push-2 {
            left: 16.66666667%;
        }
        .col-xs-push-1 {
            left: 8.33333333%;
        }
        .col-xs-push-0 {
            left: auto;
        }
        .col-xs-offset-12 {
            margin-left: 100%;
        }
        .col-xs-offset-11 {
            margin-left: 91.66666667%;
        }
        .col-xs-offset-10 {
            margin-left: 83.33333333%;
        }
        .col-xs-offset-9 {
            margin-left: 75%;
        }
        .col-xs-offset-8 {
            margin-left: 66.66666667%;
        }
        .col-xs-offset-7 {
            margin-left: 58.33333333%;
        }
        .col-xs-offset-6 {
            margin-left: 50%;
        }
        .col-xs-offset-5 {
            margin-left: 41.66666667%;
        }
        .col-xs-offset-4 {
            margin-left: 33.33333333%;
        }
        .col-xs-offset-3 {
            margin-left: 25%;
        }
        .col-xs-offset-2 {
            margin-left: 16.66666667%;
        }
        .col-xs-offset-1 {
            margin-left: 8.33333333%;
        }
        .col-xs-offset-0 {
            margin-left: 0%;
        }
        @media (min-width: 768px) {
            .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12 {
                float: left;
            }
            .col-sm-12 {
                width: 100%;
            }
            .col-sm-11 {
                width: 91.66666667%;
            }
            .col-sm-10 {
                width: 83.33333333%;
            }
            .col-sm-9 {
                width: 75%;
            }
            .col-sm-8 {
                width: 66.66666667%;
            }
            .col-sm-7 {
                width: 58.33333333%;
            }
            .col-sm-6 {
                width: 50%;
            }
            .col-sm-5 {
                width: 41.66666667%;
            }
            .col-sm-4 {
                width: 33.33333333%;
            }
            .col-sm-3 {
                width: 25%;
            }
            .col-sm-2 {
                width: 16.66666667%;
            }
            .col-sm-1 {
                width: 8.33333333%;
            }
            .col-sm-pull-12 {
                right: 100%;
            }
            .col-sm-pull-11 {
                right: 91.66666667%;
            }
            .col-sm-pull-10 {
                right: 83.33333333%;
            }
            .col-sm-pull-9 {
                right: 75%;
            }
            .col-sm-pull-8 {
                right: 66.66666667%;
            }
            .col-sm-pull-7 {
                right: 58.33333333%;
            }
            .col-sm-pull-6 {
                right: 50%;
            }
            .col-sm-pull-5 {
                right: 41.66666667%;
            }
            .col-sm-pull-4 {
                right: 33.33333333%;
            }
            .col-sm-pull-3 {
                right: 25%;
            }
            .col-sm-pull-2 {
                right: 16.66666667%;
            }
            .col-sm-pull-1 {
                right: 8.33333333%;
            }
            .col-sm-pull-0 {
                right: auto;
            }
            .col-sm-push-12 {
                left: 100%;
            }
            .col-sm-push-11 {
                left: 91.66666667%;
            }
            .col-sm-push-10 {
                left: 83.33333333%;
            }
            .col-sm-push-9 {
                left: 75%;
            }
            .col-sm-push-8 {
                left: 66.66666667%;
            }
            .col-sm-push-7 {
                left: 58.33333333%;
            }
            .col-sm-push-6 {
                left: 50%;
            }
            .col-sm-push-5 {
                left: 41.66666667%;
            }
            .col-sm-push-4 {
                left: 33.33333333%;
            }
            .col-sm-push-3 {
                left: 25%;
            }
            .col-sm-push-2 {
                left: 16.66666667%;
            }
            .col-sm-push-1 {
                left: 8.33333333%;
            }
            .col-sm-push-0 {
                left: auto;
            }
            .col-sm-offset-12 {
                margin-left: 100%;
            }
            .col-sm-offset-11 {
                margin-left: 91.66666667%;
            }
            .col-sm-offset-10 {
                margin-left: 83.33333333%;
            }
            .col-sm-offset-9 {
                margin-left: 75%;
            }
            .col-sm-offset-8 {
                margin-left: 66.66666667%;
            }
            .col-sm-offset-7 {
                margin-left: 58.33333333%;
            }
            .col-sm-offset-6 {
                margin-left: 50%;
            }
            .col-sm-offset-5 {
                margin-left: 41.66666667%;
            }
            .col-sm-offset-4 {
                margin-left: 33.33333333%;
            }
            .col-sm-offset-3 {
                margin-left: 25%;
            }
            .col-sm-offset-2 {
                margin-left: 16.66666667%;
            }
            .col-sm-offset-1 {
                margin-left: 8.33333333%;
            }
            .col-sm-offset-0 {
                margin-left: 0%;
            }
        }
        @media (min-width: 992px) {
            .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12 {
                float: left;
            }
            .col-md-12 {
                width: 100%;
            }
            .col-md-11 {
                width: 91.66666667%;
            }
            .col-md-10 {
                width: 83.33333333%;
            }
            .col-md-9 {
                width: 75%;
            }
            .col-md-8 {
                width: 66.66666667%;
            }
            .col-md-7 {
                width: 58.33333333%;
            }
            .col-md-6 {
                width: 50%;
            }
            .col-md-5 {
                width: 41.66666667%;
            }
            .col-md-4 {
                width: 33.33333333%;
            }
            .col-md-3 {
                width: 25%;
            }
            .col-md-2 {
                width: 16.66666667%;
            }
            .col-md-1 {
                width: 8.33333333%;
            }
            .col-md-pull-12 {
                right: 100%;
            }
            .col-md-pull-11 {
                right: 91.66666667%;
            }
            .col-md-pull-10 {
                right: 83.33333333%;
            }
            .col-md-pull-9 {
                right: 75%;
            }
            .col-md-pull-8 {
                right: 66.66666667%;
            }
            .col-md-pull-7 {
                right: 58.33333333%;
            }
            .col-md-pull-6 {
                right: 50%;
            }
            .col-md-pull-5 {
                right: 41.66666667%;
            }
            .col-md-pull-4 {
                right: 33.33333333%;
            }
            .col-md-pull-3 {
                right: 25%;
            }
            .col-md-pull-2 {
                right: 16.66666667%;
            }
            .col-md-pull-1 {
                right: 8.33333333%;
            }
            .col-md-pull-0 {
                right: auto;
            }
            .col-md-push-12 {
                left: 100%;
            }
            .col-md-push-11 {
                left: 91.66666667%;
            }
            .col-md-push-10 {
                left: 83.33333333%;
            }
            .col-md-push-9 {
                left: 75%;
            }
            .col-md-push-8 {
                left: 66.66666667%;
            }
            .col-md-push-7 {
                left: 58.33333333%;
            }
            .col-md-push-6 {
                left: 50%;
            }
            .col-md-push-5 {
                left: 41.66666667%;
            }
            .col-md-push-4 {
                left: 33.33333333%;
            }
            .col-md-push-3 {
                left: 25%;
            }
            .col-md-push-2 {
                left: 16.66666667%;
            }
            .col-md-push-1 {
                left: 8.33333333%;
            }
            .col-md-push-0 {
                left: auto;
            }
            .col-md-offset-12 {
                margin-left: 100%;
            }
            .col-md-offset-11 {
                margin-left: 91.66666667%;
            }
            .col-md-offset-10 {
                margin-left: 83.33333333%;
            }
            .col-md-offset-9 {
                margin-left: 75%;
            }
            .col-md-offset-8 {
                margin-left: 66.66666667%;
            }
            .col-md-offset-7 {
                margin-left: 58.33333333%;
            }
            .col-md-offset-6 {
                margin-left: 50%;
            }
            .col-md-offset-5 {
                margin-left: 41.66666667%;
            }
            .col-md-offset-4 {
                margin-left: 33.33333333%;
            }
            .col-md-offset-3 {
                margin-left: 25%;
            }
            .col-md-offset-2 {
                margin-left: 16.66666667%;
            }
            .col-md-offset-1 {
                margin-left: 8.33333333%;
            }
            .col-md-offset-0 {
                margin-left: 0%;
            }
        }
        @media (min-width: 1200px) {
            .col-lg-1, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-10, .col-lg-11, .col-lg-12 {
                float: left;
            }
            .col-lg-12 {
                width: 100%;
            }
            .col-lg-11 {
                width: 91.66666667%;
            }
            .col-lg-10 {
                width: 83.33333333%;
            }
            .col-lg-9 {
                width: 75%;
            }
            .col-lg-8 {
                width: 66.66666667%;
            }
            .col-lg-7 {
                width: 58.33333333%;
            }
            .col-lg-6 {
                width: 50%;
            }
            .col-lg-5 {
                width: 41.66666667%;
            }
            .col-lg-4 {
                width: 33.33333333%;
            }
            .col-lg-3 {
                width: 25%;
            }
            .col-lg-2 {
                width: 16.66666667%;
            }
            .col-lg-1 {
                width: 8.33333333%;
            }
            .col-lg-pull-12 {
                right: 100%;
            }
            .col-lg-pull-11 {
                right: 91.66666667%;
            }
            .col-lg-pull-10 {
                right: 83.33333333%;
            }
            .col-lg-pull-9 {
                right: 75%;
            }
            .col-lg-pull-8 {
                right: 66.66666667%;
            }
            .col-lg-pull-7 {
                right: 58.33333333%;
            }
            .col-lg-pull-6 {
                right: 50%;
            }
            .col-lg-pull-5 {
                right: 41.66666667%;
            }
            .col-lg-pull-4 {
                right: 33.33333333%;
            }
            .col-lg-pull-3 {
                right: 25%;
            }
            .col-lg-pull-2 {
                right: 16.66666667%;
            }
            .col-lg-pull-1 {
                right: 8.33333333%;
            }
            .col-lg-pull-0 {
                right: auto;
            }
            .col-lg-push-12 {
                left: 100%;
            }
            .col-lg-push-11 {
                left: 91.66666667%;
            }
            .col-lg-push-10 {
                left: 83.33333333%;
            }
            .col-lg-push-9 {
                left: 75%;
            }
            .col-lg-push-8 {
                left: 66.66666667%;
            }
            .col-lg-push-7 {
                left: 58.33333333%;
            }
            .col-lg-push-6 {
                left: 50%;
            }
            .col-lg-push-5 {
                left: 41.66666667%;
            }
            .col-lg-push-4 {
                left: 33.33333333%;
            }
            .col-lg-push-3 {
                left: 25%;
            }
            .col-lg-push-2 {
                left: 16.66666667%;
            }
            .col-lg-push-1 {
                left: 8.33333333%;
            }
            .col-lg-push-0 {
                left: auto;
            }
            .col-lg-offset-12 {
                margin-left: 100%;
            }
            .col-lg-offset-11 {
                margin-left: 91.66666667%;
            }
            .col-lg-offset-10 {
                margin-left: 83.33333333%;
            }
            .col-lg-offset-9 {
                margin-left: 75%;
            }
            .col-lg-offset-8 {
                margin-left: 66.66666667%;
            }
            .col-lg-offset-7 {
                margin-left: 58.33333333%;
            }
            .col-lg-offset-6 {
                margin-left: 50%;
            }
            .col-lg-offset-5 {
                margin-left: 41.66666667%;
            }
            .col-lg-offset-4 {
                margin-left: 33.33333333%;
            }
            .col-lg-offset-3 {
                margin-left: 25%;
            }
            .col-lg-offset-2 {
                margin-left: 16.66666667%;
            }
            .col-lg-offset-1 {
                margin-left: 8.33333333%;
            }
            .col-lg-offset-0 {
                margin-left: 0%;
            }
        }
        .clearfix:before,
        .clearfix:after,
        .container:before,
        .container:after,
        .container-fluid:before,
        .container-fluid:after,
        .row:before,
        .row:after {
            content: " ";
            display: table;
        }
        .clearfix:after,
        .container:after,
        .container-fluid:after,
        .row:after {
            clear: both;
        }

        @-ms-viewport {
            width: device-width;
        }
        .visible-xs,
        .visible-sm,
        .visible-md,
        .visible-lg {
            display: none !important;
        }
        .visible-xs-block,
        .visible-xs-inline,
        .visible-xs-inline-block,
        .visible-sm-block,
        .visible-sm-inline,
        .visible-sm-inline-block,
        .visible-md-block,
        .visible-md-inline,
        .visible-md-inline-block,
        .visible-lg-block,
        .visible-lg-inline,
        .visible-lg-inline-block {
            display: none !important;
        }
        @media (max-width: 767px) {
            .visible-xs {
                display: block !important;
            }
            table.visible-xs {
                display: table !important;
            }
            tr.visible-xs {
                display: table-row !important;
            }
            th.visible-xs,
            td.visible-xs {
                display: table-cell !important;
            }
        }
        @media (max-width: 767px) {
            .visible-xs-block {
                display: block !important;
            }
        }
        @media (max-width: 767px) {
            .visible-xs-inline {
                display: inline !important;
            }
        }
        @media (max-width: 767px) {
            .visible-xs-inline-block {
                display: inline-block !important;
            }
        }
        @media (min-width: 768px) and (max-width: 991px) {
            .visible-sm {
                display: block !important;
            }
            table.visible-sm {
                display: table !important;
            }
            tr.visible-sm {
                display: table-row !important;
            }
            th.visible-sm,
            td.visible-sm {
                display: table-cell !important;
            }
        }
        @media (min-width: 768px) and (max-width: 991px) {
            .visible-sm-block {
                display: block !important;
            }
        }
        @media (min-width: 768px) and (max-width: 991px) {
            .visible-sm-inline {
                display: inline !important;
            }
        }
        @media (min-width: 768px) and (max-width: 991px) {
            .visible-sm-inline-block {
                display: inline-block !important;
            }
        }
        @media (min-width: 992px) and (max-width: 1199px) {
            .visible-md {
                display: block !important;
            }
            table.visible-md {
                display: table !important;
            }
            tr.visible-md {
                display: table-row !important;
            }
            th.visible-md,
            td.visible-md {
                display: table-cell !important;
            }
        }
        @media (min-width: 992px) and (max-width: 1199px) {
            .visible-md-block {
                display: block !important;
            }
        }
        @media (min-width: 992px) and (max-width: 1199px) {
            .visible-md-inline {
                display: inline !important;
            }
        }
        @media (min-width: 992px) and (max-width: 1199px) {
            .visible-md-inline-block {
                display: inline-block !important;
            }
        }
        @media (min-width: 1200px) {
            .visible-lg {
                display: block !important;
            }
            table.visible-lg {
                display: table !important;
            }
            tr.visible-lg {
                display: table-row !important;
            }
            th.visible-lg,
            td.visible-lg {
                display: table-cell !important;
            }
        }
        @media (min-width: 1200px) {
            .visible-lg-block {
                display: block !important;
            }
        }
        @media (min-width: 1200px) {
            .visible-lg-inline {
                display: inline !important;
            }
        }
        @media (min-width: 1200px) {
            .visible-lg-inline-block {
                display: inline-block !important;
            }
        }
        @media (max-width: 767px) {
            .hidden-xs {
                display: none !important;
            }
        }
        @media (min-width: 768px) and (max-width: 991px) {
            .hidden-sm {
                display: none !important;
            }
        }
        @media (min-width: 992px) and (max-width: 1199px) {
            .hidden-md {
                display: none !important;
            }
        }
        @media (min-width: 1200px) {
            .hidden-lg {
                display: none !important;
            }
        }
        .visible-print {
            display: none !important;
        }
        @media print {
            .visible-print {
                display: block !important;
            }
            table.visible-print {
                display: table !important;
            }
            tr.visible-print {
                display: table-row !important;
            }
            th.visible-print,
            td.visible-print {
                display: table-cell !important;
            }
        }
        .visible-print-block {
            display: none !important;
        }
        @media print {
            .visible-print-block {
                display: block !important;
            }
        }
        .visible-print-inline {
            display: none !important;
        }
        @media print {
            .visible-print-inline {
                display: inline !important;
            }
        }
        .visible-print-inline-block {
            display: none !important;
        }
        @media print {
            .visible-print-inline-block {
                display: inline-block !important;
            }
        }
        @media print {
            .hidden-print {
                display: none !important;
            }
        }
    </style>
    <style>
        @page { size: 1137.5px 807.9px; }
        @font-face {
            font-family: ProximaNova;
            src: url({{ storage_path("fonts/Proxima Nova Regular.otf") }});
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: ProximaNovaBold;
            src: url({{ storage_path('fonts/Proxima Nova Bold.otf') }});
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: ProximaNovaBlack;
            src: url({{ storage_path('fonts/Proxima Nova Black.otf') }});
            font-weight: normal;
            font-style: normal;
        }
        * {
            background-repeat: no-repeat;
            padding: 0;
            margin: 0;
        }
        *, :after, :before {
            box-sizing: inherit;
        }
        html {
            display: block;
            font-size: 14px;
            overflow-x: hidden;
            text-rendering: optimizeLegibility;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            -webkit-tap-highlight-color: rgba(0,0,0,0);
            box-sizing: border-box;
            overflow-y: scroll;
            -webkit-text-size-adjust: 100%;
        }
        .page-break {
            page-break-after: always;
        }
        #pdf {
            position: absolute;
            font-family: ProximaNova;
            padding: 0;
            margin: 0;
            width: 1137.5px;
            height: 100%;
        }

        .page {
            position: relative;
            width: 1137.5px;
            height: 807.9px;
        }
    </style>
</head>
<body>
    <div class="container-fluid" id="pdf">
        @include('pdf.firstPage.first_page')

        @include('pdf.secondPage.second_page')

        @if(isset($data[$pdf_names['CONNECT_TO_PLATFORM']]))
            @include('pdf.connectionToPlatform.ConnectionToPlatformTitle', [
                'price' => $data[$pdf_names['CONNECT_TO_PLATFORM']]['price']
            ])
            @include('pdf.connectionToPlatform.ConnectionToPlatformProgramPart')
        @endif

        @if(isset($data[$pdf_names['MONITORING']]))
            @include('pdf.monitoring.monitoring')
        @endif

        @if(isset($data[$pdf_names['FIELD_MAPPING_BY_DRONES']]))
            @include('pdf.fieldsMappingByDrones.fieldsMappingByDrones', [
                'price' => $data[$pdf_names['FIELD_MAPPING_BY_DRONES']]['price']
            ])
        @endif

        @if(isset($data[$pdf_names['FIELD_MAPPING_BY_PHYSICAL_MEASUREMENT']]))
            @include('pdf.fieldsMappingByPh.fieldsMappingByPh', [
                'price' => $data[$pdf_names['FIELD_MAPPING_BY_PHYSICAL_MEASUREMENT']]['price']
            ])
        @endif

        @if(isset($data[$pdf_names['LAND_BANK_ACCOUNTING']]))
            @include('pdf.landBankAccounting.landBankAccountingTitle')
            @include('pdf.landBankAccounting.LandBankAccountingList', [
                'price' => $data[$pdf_names['LAND_BANK_ACCOUNTING']]['price']
            ])
        @endif

        @if(isset($data[$pdf_names['ENGINEER_PROJECT']]))
            @include('pdf.GPSTracking.GPSTrackingTitle')

            @for($i = 0; $i < count($data[$pdf_names['ENGINEER_PROJECT']]['gpsTrackingData']); ++$i)
                @if($data[$pdf_names['ENGINEER_PROJECT']]['gpsTrackingData'][$i]['multiplier'] > 0)
                    @for($n = 0; $n < $data[$pdf_names['ENGINEER_PROJECT']]['gpsTrackingData'][$i]['multiplier']; ++$n)
                        @include('pdf.GPSTracking.GPSTrackingData', [
                            'index' => $i,
                            'equipment' => $data[$pdf_names['ENGINEER_PROJECT']]['gpsTrackingData'][$i]['equipment'],
                            'transportImage' => $data[$pdf_names['ENGINEER_PROJECT']]['gpsTrackingData'][$i]['transportImage'],
                            'transportName' => $data[$pdf_names['ENGINEER_PROJECT']]['gpsTrackingData'][$i]['transportName']
                        ])
                    @endfor
                @endif
            @endfor
        @endif

        @if(isset($data[$pdf_names['PARTOL']]))
            @include('pdf.patrol.patrol', [
                'price' => $data[$pdf_names['PARTOL']]['price']
            ])
        @endif

        @if(isset($data[$pdf_names['NDVI']]))
            @include('pdf.NDVI.NDVI', [
                'price' => $data[$pdf_names['NDVI']]['price']
            ])
        @endif

        @if(isset($data[$pdf_names['COUNTING_SEEDLINGS']]))
            @include('pdf.countingSeedlings.countingSeedlings', [
                'price' => $data[$pdf_names['COUNTING_SEEDLINGS']]['price']
            ])
        @endif

        @if(isset($data[$pdf_names['ENGINEER_SUPPORT']]))
            @include('pdf.engineerSupport.engineerSupport', [
                'price' => $data[$pdf_names['ENGINEER_SUPPORT']]['price']
            ])
        @endif

        @if(isset($data[$pdf_names['PHOTO_VIDEO']]))
            @include('pdf.aeroVisualReview.aeroVisualReviewTitle', [
                'price' => $data[$pdf_names['PHOTO_VIDEO']]['price']
            ])
            @include('pdf.aeroVisualReview.AeroVisualReviewDataFirstPage')
            @include('pdf.aeroVisualReview.AeroVisualReviewDataSecondPage')
        @endif

        @if(isset($data[$pdf_names['SAS_MAPPER']]))
            @include('pdf.SASMapper.SASMapper', [
                'price' => $data[$pdf_names['SAS_MAPPER']]['price']
            ])
        @endif

        @if(isset($data[$pdf_names['CHEMICAL_SOIL_ANALYSIS']]))
            @include('pdf.chemicalAnalysisOfSoils.chemicalAnalysisOfSoils', [
                'price' => $data[$pdf_names['CHEMICAL_SOIL_ANALYSIS']]['price']
            ])
        @endif

        @if(isset($data[$pdf_names['MEASURING_THE_HARDNESS_OF_THE_SOIL']]))
            @include('pdf.soilHardnessMeasuring.soilHardnessMeasuring', [
                'price' => $data[$pdf_names['MEASURING_THE_HARDNESS_OF_THE_SOIL']]['price']
            ])
        @endif

        @if(isset($data[$pdf_names['INTEGRATION_1C']]))
            @include('pdf.1CIntegration.1CIntegration')
            @include('pdf.1CIntegration.1CPrices', [
                'prices' => $data[$pdf_names['INTEGRATION_1C']]['prices']
            ])
        @endif

        @if(isset($data[$pdf_names['ENGINEER_PROJECT']]))
            @php
                $gruppedEquipment = $data[$pdf_names['ENGINEER_PROJECT']]['gruppedEquipment'];
                $slicedGruppedEquipment = array_chunk($gruppedEquipment, 8);
            @endphp

            @foreach($slicedGruppedEquipment as $slice)
                @include('pdf.engineerProject.engineerProject', [
                    'showPrices' => $loop->last,
                    'gruppedEquipmentLength' => count($slice),
                    'data' => $slice,
                    'formattedPriceForDays' => $data[$pdf_names['ENGINEER_PROJECT']]['formattedPriceForDays'],
                    'formattedEquipmentPrice' => $data[$pdf_names['ENGINEER_PROJECT']]['formattedEquipmentPrice'],
                    'formattedInstallationPrice' => $data[$pdf_names['ENGINEER_PROJECT']]['formattedInstallationPrice'],
                    'formattedTransportPrice' => $data[$pdf_names['ENGINEER_PROJECT']]['formattedTransportPrice'],
                    'formattedFinalPrice' => $data[$pdf_names['ENGINEER_PROJECT']]['formattedFinalPrice'],
                    'dollarDate' => $data[$pdf_names['ENGINEER_PROJECT']]['dollarDate']
                ])
            @endforeach
        @endif

        @if(isset($data['servicePrices']) && isset($data['servicePrices']['servicePrices']) && count($data['servicePrices']['servicePrices']) > 0)
            @include('pdf.servicePrices.servicePrices', [
                'dollarDate' => $data['servicePrices']['dollarDate'],
                'finalPrice' => $data['servicePrices']['finalPrice'],
                'servicePrices' => $data['servicePrices']['servicePrices']
            ])
        @endif

        @if(isset($data['optionalServices']))
            @foreach($data['optionalServices'] as $optionalService)
                @include('pdf.optionalServices.optionalServices', [
                    'optionalService' => $optionalService
                ])
            @endforeach
        @endif

        @include('pdf.contacts.contacts')
    </div>
</body>
</html>
<div class="left-img" style="background-image: url('{{ $image }}');"></div>
<div class="left-img-shadow"></div>

<style>
    .left-img {
        background-position-y: 43%;
        position: relative;
        float: left;
        width: 33.33333333%;
        height: 807.9px;
    }

    .left-img-shadow {
        position: absolute;
        background: url('/storage/shadow.png') repeat-y;
        top: 0px;
        left: 380px;
        width: 23px;
        height: 807.9px;
        z-index: 1;
    }
</style>
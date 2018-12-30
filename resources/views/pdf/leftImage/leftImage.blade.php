<div class="left-img">
    @include('pdf.backgroundImage.BackgroundImage', ['image' => $image])
</div>
<div class="left-img-shadow">
    @include('pdf.backgroundImage.BackgroundImage', ['image' => 'storage/shadow.png'])
</div>

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
        top: 0px;
        left: 380px;
        width: 23px;
        height: 807.9px;
        z-index: 1;
    }
</style>
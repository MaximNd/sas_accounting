<div id="aero-visual-review-data-first-page" class="page">
    @include('pdf.leftImage.leftImage', ['image' => '/storage/image65_s.jpg'])
    <div class="aero-data">
        <div class="data-block">
            <div class="aero-data-title">
                Озима пшениця
            </div>
            <div class="aero-data-img" style="margin-bottom: -30px;">
                <img src="storage/image61.png" alt="img">
            </div>
            <div class="aero-data-seasons">
                <div class="season" style="margin-left: 66px;">
                    <div class="month">
                        <span>Жовт. Листоп.</span>
                    </div>
                    <div class="durability">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>
                    <div class="drone">
                        <img style="margin-left: 13px;" src="storage/image-drone.png"alt="drone">
                    </div>
                </div>
                <div class="season" style="margin-left: 115px;">
                    <div class="month">
                        <span>Берез. Квіт. Трав.</span>
                    </div>
                    <div class="durability">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>
                    <div class="drone">
                        <img style="margin-left: 29px;" src="storage/image-drone.png" alt="drone">
                    </div>
                </div>
            </div>
        </div>
        <div class="data-block">
            <div class="aero-data-title" style="margin-top: -10px;">
                Ріпак
            </div>
            <div class="aero-data-img" style="margin-bottom: -20px;">
                <img src="storage/image63.png" alt="img">
                <div style="position: absolute; z-index: 5; width: 10px; height: 200px; background-color: #fff; left: 680px; top: 455px;"></div>
            </div>
            <div class="aero-data-seasons">
                <div class="season" style="margin-left: 45px;">
                    <div class="month">
                        <span>Жовт. Листоп.</span>
                    </div>
                    <div class="durability">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>
                    <div class="drone">
                        <img style="margin-left: 12.5px;" src="storage/image-drone.png"alt="drone">
                    </div>
                </div>
                <div class="season" style="margin-left: 230px;">
                    <div class="month">
                        <span>Берез. Квіт. Трав.</span>
                    </div>
                    <div class="durability">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>
                    <div class="drone">
                        <img style="margin-left: 30px;" src="storage/image-drone.png" alt="drone">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="aero-bottom-logo">
        <img class="sas-logo" src="storage/image4.png" alt="logo">
    </div>
</div>
<div class="page-break"></div>

<style>
    #aero-visual-review-data-first-page {
        position: relative;
        width: 100%;
    }

    #aero-visual-review-data-first-page .aero-data {
        width: 66.66666667%;
        height: 807.9px;
        float: left;
    }

    #aero-visual-review-data-first-page .aero-data .data-block {
        width: 100%;
        height: 50%;
    }

    #aero-visual-review-data-first-page .aero-data .data-block .aero-data-title {
        height: 85px;
        font-family: ProximaNovaBlack;
        color: #4D4D4D;
        font-size: 40px;
        text-align: center;
        margin-top: 10px;
        margin-bottom: 20px;
    }

    #aero-visual-review-data-first-page .aero-data .data-block .aero-data-img img {
        max-width: 91%;
    }

    #aero-visual-review-data-first-page .aero-data .data-block .aero-data-seasons .season {
        display: inline-block;
    }

    #aero-visual-review-data-first-page .aero-data .data-block .aero-data-seasons .season .month {
        font-family: ProximaNova;
        font-size: 18px;
    }

    #aero-visual-review-data-first-page .aero-data .data-block .aero-data-seasons .season .durability {
        /*min-width: 108px;*/
        height: 30px;
        /*background-color: #ff00ff;*/
        border-left: 1.8px solid #000;
        border-bottom: 1.8px solid #000;
        border-right: 1.8px solid #000;
    }

    #aero-visual-review-data-first-page .aero-data .data-block .aero-data-seasons .season .drone {
        margin-top: 10px;
    }

    #aero-visual-review-data-first-page .aero-data .data-block .aero-data-seasons .season .drone img {
        display: block;
        max-width: 100%;
        margin: 0 auto;
    }

    #aero-visual-review-data-first-page .aero-bottom-logo {
        position: absolute;
        left: 927px;
        top: 758px;
        width: 210px;
        height: 50px;
    }

    #aero-visual-review-data-first-page .aero-bottom-logo img {
        margin-right: 10px;
        margin-bottom: 10px;
        width: 200px;
    }
</style>
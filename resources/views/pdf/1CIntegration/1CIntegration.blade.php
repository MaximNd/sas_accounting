<div id="integration-1c" class="page">
    @include('pdf.leftImage.leftImage', ['image' => '/storage/image89_s.jpg'])
    @include('pdf.serviceData.serviceData', [
        'grid' => true,
        'data' => [
            'title' => '1С інтеграція',
            'subtitle' => 'Система Cropio має можливість двосторонньої інтеграції даних з 1С',
            'data' => [
                [ 'iconStyles' => 'top:58px;left:67px;', 'textStyles' => 'top:130px;left:50px;', 'icon' => 'storage/image90.png', 'text' => 'КУЛЬТУРИ' ],
                [ 'iconStyles' => 'top:57px;left:61px;', 'textStyles' => 'top:130px;left:40px;', 'icon' => 'storage/image91.png', 'text' => 'НАСІННЯ' ],
                [ 'iconStyles' => 'top:57px;left:58px;', 'textStyles' => 'top:130px;left:32px;', 'icon' => 'storage/image92.png', 'text' => 'ДОБРИВА' ],
                [ 'iconStyles' => 'top:58px;left:55px;', 'textStyles' => 'top:130px;left:28px;', 'icon' => 'storage/image93.png', 'text' => 'ХІМІКАТИ' ],

                [ 'iconStyles' => 'top:48px;left:65px;', 'textStyles' => 'top:120px;left:40px;', 'icon' => 'storage/image94.png', 'text' => 'АГРООПЕРАЦІЇ' ],
                [ 'iconStyles' => 'top:50px;left:65px;', 'textStyles' => 'top:125px;left:0px;line-height:0.9;width:200px;', 'icon' => 'storage/image95.png', 'text' => 'ЗВІТИ ОГЛЯДУ ПОЛІВ' ],
                [ 'iconStyles' => 'top:50px;left:60px;', 'textStyles' => 'top:125px;left:0px;line-height:0.9;width:200px;', 'icon' => 'storage/image96.png', 'text' => 'МАШИНИ І ОБЛАДНАННЯ' ],
                [ 'iconStyles' => 'top:50px;left:55px;', 'textStyles' => 'top:125px;left:30px;line-height:0.9;', 'icon' => 'storage/image97.png', 'text' => 'ЗАВДАННЯ МАШИН' ]
            ],
            'iconWidth' => '7.5%',
            'textWidth' => '92.5%',
            'listMarginLeft' => '50px',
            'listMarginTop' => '45px'
        ]
    ])
    <div class="clearfix"></div>
</div>
<div class="page-break"></div>

<style>
    #integration-1c {
        position: relative;
        width: 100%;
    }
</style>
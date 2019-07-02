<?php

$app->group('/synctree-tf', function () {

    $this->get('/getProducts', 'controllers\internal\TravelForest:getProducts')->setName('product'); // 모상품리스트
    $this->post('/getProduct', 'controllers\internal\TravelForest:getProduct')->setName('product'); // 모상품 상세정보
    $this->post('/getProduct/{subProduct}', 'controllers\internal\TravelForest:getProduct')->setName('product'); // 자상품 상세 정보
    $this->post('/authCheck', 'controllers\internal\TravelForest:authCheck')->setName('auth'); // 권한 체크
    $this->get('/getProductIdx/{productTypeKey:[0-9]+}', 'controllers\internal\TravelForest:getProductIdx')->setName('product'); // 자상품 IDX로 모상품 IDX 가지고 온다.

    $this->get('/setProductsBatch', 'controllers\internal\TravelForest:setProductsBatch')->setName('batch'); // TF 상품 배치
    $this->get('/setProductBatch/{area_idx}/{product_idx}', 'controllers\internal\TravelForest:setProductBatch')->setName('batch');

    $this->post('/addBooking', 'controllers\internal\TravelForest:addBooking')->setName('booking'); // 예약생성 메퍼
    $this->get('/proceedBooking/{bookingKey:[0-9]+}', 'controllers\internal\TravelForest:proceedBooking')->setName('booking'); // 예약진행 매퍼
    $this->get('/cancelBooking/{bookingKey:[0-9]+}', 'controllers\internal\TravelForest:cancelBooking')->setName('booking'); // 예약취소 매퍼
    $this->get('/checkBookingStatus/{bookingKey:[0-9]+}', 'controllers\internal\TravelForest:checkBookingStatus')->setName('booking'); // 예약진행 매퍼

    $this->put('/bookingUpdate/{bookingKey:[0-9]+}/{updateType:[a-z]+}', 'controllers\internal\TravelForest:bookingUpdate')->setName('booking'); // 예약 Webhook

    $this->put('/productUpdate/{productKey:[0-9]+}', 'controllers\internal\TravelForest:productUpdate')->setName('booking'); // 상품 Webhook
    $this->put('/productUpdate/{productKey:[0-9]+}/{productTypeKey:[0-9]+}', 'controllers\internal\TravelForest:productUpdate')->setName('booking'); // 상품 Webhook

    $this->post('/secure/getCommand', 'controllers\internal\TravelForest:getCommand')->setName('getCommand'); // 보안 프로토콜

    if (APP_ENV !== APP_ENV_PRODUCTION) {
        $this->get('/secure/getEventKey', 'controllers\internal\TravelForest:getEventKey')->setName('getCommand'); // 보안 프로토콜 이벤트키 발급
    }

    $this->group('/tourvis/api', function () {

        switch (APP_ENV) {
            case APP_ENV_DEVELOPMENT_LOCAL_KIMILDO :
            case APP_ENV_DEVELOPMENT :

                // 모상품 목록
                $this->get('/v1/{supplierCode}/products', 'controllers\generated\usr\owner_nntuple_com\GenerateffUecF43IcM1m5cBrAGXHkController:main')->setName('main');

                // 모상품 상세
                $this->get('/v1/{supplierCode}/products/{productKey:[0-9]+}',
                    'controllers\generated\usr\owner_nntuple_com\GenerateuONxfxovEnkAZvMFCAWBzlController:main')->setName('main');

                // 자상품 리스트
                $this->get('/v1/{supplierCode}/products/{productKey:[0-9]+}/{productTypes:[a-z\-]{13}}',
                    'controllers\generated\usr\owner_nntuple_com\GenerateHRNHfBC1C0ccaCzCxfvddbController:main')->setName('main');

                // 자상품 상세
                $this->get('/v1/{supplierCode}/{productTypes:[a-z\-]{13}}/{productTypeKey:[0-9]+}',
                    'controllers\generated\usr\owner_nntuple_com\Generate47p9A8I1VuMguPA5Cz0xa8Controller:main')->setName('main');

                // 자상품 날짜 검색
                $this->get('/v1/{supplierCode}/{productTypes:[a-z\-]{13}}/{productTypeKey:[0-9]+}/price',
                    'controllers\generated\usr\owner_nntuple_com\GeneratelLmX6Q5SqAABaMDRTGqaNnController:main')->setName('main');

                // 예약생성
                $this->post('/v1/{supplierCode}/book',
                    'controllers\generated\usr\owner_nntuple_com\GenerateKdEx1crXzerSfj8dWr9pmmController:main')->setName('main');

                // 예약진행
                $this->put('/v1/{supplierCode}/book/{bookingKey:[0-9]+}/confirm',
                    'controllers\generated\usr\owner_nntuple_com\GenerateXmKWZuZgxTAMz9RVM3DcgyController:main')->setName('main');

                // 예약취소
                $this->put('/{supplierCode}/book/{bookingKey:[0-9]+}/cancel',
                    'controllers\generated\usr\owner_nntuple_com\GenerateM9GXOBdtvQRA8A1clW15BHController:main')->setName('main');

                // 예약상태 확인
                $this->get('/{supplierCode}/book/{bookingKey:[0-9]+}',
                    'controllers\generated\usr\owner_nntuple_com\GeneratevXEhAKkdIJQL6HBpSLMOALController:main')->setName('main');

                break;

            case APP_ENV_STAGING :
            case APP_ENV_PRODUCTION :

                // 모상품 목록
                $this->get('/v1/{supplierCode}/products', 'controllers\generated\usr\tony_oh_travelforest_co_kr\GenerateekbjUdv93ES7MfWKZgNM99Controller:main')->setName('main');

                // 모상품 상세
                $this->get('/v1/{supplierCode}/products/{productKey:[0-9]+}',
                    'controllers\generated\usr\tony_oh_travelforest_co_kr\GenerateWZpYpTdzbqVYdtXfSACyMXController:main')->setName('main');

                // 자상품 리스트
                $this->get('/v1/{supplierCode}/products/{productKey:[0-9]+}/{productTypes:[a-z\-]{13}}',
                    'controllers\generated\usr\tony_oh_travelforest_co_kr\GenerateUsR8n8zTC0YG7fr41ozpDbController:main')->setName('main');

                // 자상품 상세
                $this->get('/v1/{supplierCode}/{productTypes:[a-z\-]{13}}/{productTypeKey:[0-9]+}',
                    'controllers\generated\usr\tony_oh_travelforest_co_kr\Generatep8bnPaFrXRD18rQnu3eIu8Controller:main')->setName('main');

                // 자상품 날짜 검색
                $this->get('/v1/{supplierCode}/{productTypes:[a-z\-]{13}}/{productTypeKey:[0-9]+}/price',
                    'controllers\generated\usr\tony_oh_travelforest_co_kr\GenerateGkqiAEHnbFsBhwSqxzkJ74Controller:main')->setName('main');

                // 예약생성
                $this->post('/v1/{supplierCode}/book',
                    'controllers\generated\usr\tony_oh_travelforest_co_kr\Generate2ikG4ygrAGw2znVr8hdq9vController:main')->setName('main');

                // 예약진행
                $this->put('/v1/{supplierCode}/book/{bookingKey:[0-9]+}/confirm',
                    'controllers\generated\usr\tony_oh_travelforest_co_kr\GeneratebzjSIazKVCVMmtSG92ZpP0Controller:main')->setName('main');

                // 예약취소
                $this->put('/{supplierCode}/book/{bookingKey:[0-9]+}/cancel',
                    'controllers\generated\usr\tony_oh_travelforest_co_kr\GenerateTSQwk0ViFINl2i7BcfJ7vAController:main')->setName('main');

                // 예약상태 확인
                $this->get('/{supplierCode}/book/{bookingKey:[0-9]+}',
                    'controllers\generated\usr\tony_oh_travelforest_co_kr\GenerateTbURRHd5VhbdVBQH30A9b2Controller:main')->setName('main');


                break;
        }

    });



})
->add(new \middleware\Common($app->getContainer(), false))
;
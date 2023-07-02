<?php

function getUrl($input)
{
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://tools.sinhvienit.net/ajax.php',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => 'do=barcode&input=' . $input . '&type=code128',
    CURLOPT_HTTPHEADER => array(
      'Content-Type: application/x-www-form-urlencoded',
      'Cookie: __cfduid=d856298c980fbe537c7ab51a8254526801619092629'
    ),
  ));

  $response = curl_exec($curl);

  curl_close($curl);
  echo substr($response, 3);
}
print_r( getPayCode('zpt=g4txwgDRiTvemkec8si2QNP9Hlhw/RTY0Aeuc9Ro/r89EIIiQ2dL48AB2dr8qulU0M0tMXtDGXYQQHu2Ccv58yywOpyyw761Y+ncPODwq7723eAZ+lt+GJ1xynLY41frFl5Wfq8rybgxTdE70ofoLQ==; abt=on; _ga=GA1.2.1084912338.1618671747; _fbp=fb.1.1618671748411.1286395005; _zpc=stable; _gid=GA1.2.1849761700.1618926008; is_new_user=1; fpsend=149908; zalo_id=7993297273064222886; zalopay_id=210421002504849; zalo_oauth=Z0xTYLpu_6Bi8hh6Slwk2zKUXwSusB4BbnRDXK_1Wbkc0BMAAzxwACSjxfDRyyWwipFxcIdbbplC3T7lBC_WCwyHevOrsB4Rcd20YdEfiopAQ-kpACUyJkLvqjmv_iWhkYBxbZNYl6U3STM5PwVjVvD8ghnpW8jqrdJBra6zhctQV9wqSllqHB9euA4FmhXvx0QNec_DoN-BSCE_QBJpIzaeaFu9kuKxiapIbGhDl13Q2VEcIUx07z8ruAazyCPlos3HitOUarwdpUUt8YIn9OpWdQm33Sqws_Bhg4-bleRxMyzhAos06GN6ze-f3hf2KSNl_jiNlJKLnvwnY36cTGYJvygUFRKE5u3ssYOypfaUNDogP0; h5token=f2c1db8a448de5fbe5ab8b214c1949deCQsl4QZLNB9n4NeRlBzBDke34dZtdd7C; zlp_token=giytanbsgeydamrvga2dqnbz.NLHFejX24ddnB6QhYrYg3C61jKNeGd4H.d6b263444d2cb11bf2406519209575c5; trackingsession=432e0c03-183e-4d5f-b09f-c300e507549e; tsession=432e0c03-183e-4d5f-b09f-c300e507549e; _gat=1; __zi=3000.SSZzejyD0jydXVUYoam4q7o7exo4GXoJ89MfevO03eKoclUedqb7XJkN-g7JGKcCVfRzeDv7J8qvCW.1; useragent=TW96aWxsYS81LjAgKFdpbmRvd3MgTlQgMTAuMDsgV2luNjQ7IHg2NCkgQXBwbGVXZWJLaXQvNTM3LjM2IChLSFRNTCwgbGlrZSBHZWNrbykgQ2hyb21lLzkwLjAuNDQzMC43MiBTYWZhcmkvNTM3LjM2; _uafec=Mozilla%2F5.0%20(Windows%20NT%2010.0%3B%20Win64%3B%20x64)%20AppleWebKit%2F537.36%20(KHTML%2C%20like%20Gecko)%20Chrome%2F90.0.4430.72%20Safari%2F537.36; '));
function getPayCode($cookie)
{


  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://sapi.zalopay.vn/v1/quick-pay/get-payment-codes',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => '{
  "pin": "GK8pIgJhewn9LfD0cHX3iPXGWKKi47kSc9lSMeva8xlKbqR7ytDB+ibZH3C6lSdh+zPviMc3jmi550eOS8yvBDXChp/ykFi8VJlzyas3CxYtdn2h5Zdizf43wlznFkTBPLJftSdNmrWU9wYIvMSDgGNXxWgFDb9pXdvxhxEKXG+dUEboitSfAmqPTA2ib5U53wPEqdau+QE9e9dn/bZfE0cKrI6z2n5673eSTLYNL+TjYu7/dJndFiI2E4oi2uQsyEEe6QBUU0ZAL5J/rTT+pZhr8xITaL2pRB+Z+i5ru20AEBxuezkWn/35OFG52twR4a7/1SCxdDpjCAEiJOHhHw\\u003d\\u003d"
}',
    CURLOPT_HTTPHEADER => array(
      'cookie: ' . $cookie,
      'Content-Type: text/plain'
    ),
  ));

  $response = curl_exec($curl);

  curl_close($curl);
  return json_decode($response, true);
}


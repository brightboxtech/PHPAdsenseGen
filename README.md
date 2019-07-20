# PHPAdsenseGen
Simple class to generate adsense units for both asynchronous (responsive) and synchronous ads

You can simply include the main file and be able to generate Adsense ads for your site using PHP. Below is an example:

include('./adsense.php');
    
$ad_settings = array(
    'type'      =>  'async',
    'clientid'  =>  '',
    'slotid'    =>  21313423545,
    'channel'   =>  '',
    'format'    =>  '',
    'comments'  =>  '',
    'style'     =>  '',
    'class'     =>  '',
    'mobile'    =>  0,
    'inscript'  =>  0,
    'inpush'    =>  0,
    'ezid'      =>  0,
    'ezname'    =>  '',
    'ezplace'   =>  '',
    'height'   =>  0,
    'width'    =>  0
);
    
$adsense = new Adsense();
$adsense->setClientID('pub-123565325');
$adsense->setAdStatus('live');
$adsense->setadDefaultStyle('border:1px #000 solid;padding:10px;height:100px;margin:10px;','testadclass');
$ad_unit = $adsense->generateAdUnit($ad_settings);

For Ezoic users who also has Adsense on their site, you can also use this to generate the Ezoic wrap code to wrap your Adsense code with your Ezoic placeholders.

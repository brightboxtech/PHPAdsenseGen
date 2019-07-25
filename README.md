# PHPAdsenseGen
Simple class to generate adsense units for both asynchronous (responsive) and synchronous ads

You can simply include the main file and it will then allow you to generate Adsense ads for your site using PHP. For Ezoic users who also has Adsense on their site, you can also use this to generate the Ezoic wrap code to wrap your Adsense code with your Ezoic placeholders. I created this class under the PHP version 7.3.4. Below is an example:

``` php
include('./adsense.php');
    
$ad_settings = array(
    /* This tells the class which type of code you want to build the ad unit for. Options are
     * async (For responsive ads),
     * sync (For non-responsive ads)
    */
    
    'type'      =>  'async',
    
    /* This is the client ID Adsense assigns you. You have the option of assigning this at a per
     * ad unit level or you can leave this blank and use the client ID you set globally
    */
    
    'clientid'  =>  '',
    
    /* This is the unique ID Adsense give syou when you create an ad in their system */
    
    'slotid'    =>  21313423545,
    
    /* If you create a channel and assign an ad to it, you can put the channel ID Adsense
     * assigns it here
    */
    
    'channel'   =>  '',
    
    /* This allows you to specify the format of the ad, this is used for responsive ads only.
     * The options are auto, horizontal, vertical or rectangle
    */
    
    'format'    =>  '',
    
    /* This allows you to add any custom comments you want to display for this ad. It uses hidden
     * comments so the person wont see it on the page itself, unless they view the code
     
    'comments'  =>  '',
    
    /* This allows you to use custom css styles. If left empty, it will use display:block
     * by default
    */
    
    'style'     =>  '',
    
    /* This allows you to use a custom class name for this ad unit */
    
    'class'     =>  '',
    
    /* This allows you to turn on/off full width ads for mobile. The attribute this uses is
     * data-full-width-responsive with it being true or false, depending on the value below
    */
    
    'mobile'    =>  0,
    
    /* This allows you to include or not include the external JS file needed for your ad unit. You
     * could either do it for each ad unit you create, or request it once using the public function 
     * generateIncludeScript() so you only include the script once in your page
    */
    
    'inscript'  =>  0,
    
    /* This allows you to include the push script needed for responsive ads. You can do it per ad
     * unit, or do it just once by using the parent function generatePushScript()
    */
    
    'inpush'    =>  0,
    
    /* If you have Ezoic and need to wrap your Adsense ads, put your Ezoic ID here */
    
    'ezid'      =>  0,
    
    /* If you have Ezoic and need to wrap your Adsense ads, put the name of the Ezoic unit here */
    
    'ezname'    =>  '',
    
    /* If you have Ezoic and need to wrap your Adsense ads, put the location of the Ezoic place
     * holder here
    */
    
    'ezplace'   =>  '',
    
    /* If you are using a non responsive ad, you need to specify the height and width here */
    
    'height'   =>  0,
    
    /* If you are using a non responsive ad, you need to specify the height and width here */
    
    'width'    =>  0
    
);
    
/* This calls the Adsense generation class */
$adsense = new Adsense();

/* This assigns your Adsense client ID globally. So it will be used for each ad unit you
 * generate from here on out, or you can also assign a client ID to a ad unit specifically
 * through the settings array above
*/
$adsense->setClientID('pub-123565325');

/* This allows you to set the current status of your ads. The options are none (Meaning
 * dont display any ads), test (Meaning only display a div place holder that will use your
 * custom style and or class you set in the settings array above or live (This will create
 * the live ad to use on your page)
*/
$adsense->setAdStatus('live');

/* This allows you to set the custom style and class to be used if your ad status is set
 * to test. That you you dont have to set it for every ad you generate. It will use this
 * for every test ad. You can use both or either or
*/
$adsense->setadDefaultStyle('border:1px #000 solid;height:100px;','testadclass');

/* This generates the ad unit based off the settings array above. It will assign the ad
 * unit code to the variable, or you can simply just echo it out
*/
$ad_unit = $adsense->generateAdUnit($ad_settings);
```

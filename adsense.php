<?php

    class Adsense {
        
        private $clientid;
        private $adstatus;        
        private $teststyle;
        private $testclass;
        
        public function setClientID($clientid = '')
        {
            
            $this->clientid = trim($clientid);
            
            return;
            
        }
        
        public function setAdStatus($status = 'none')
        {
            
            //We globally assign the current ad status. Options are none (Do not display an ad),
            //test (Returns a blank div), live (Returns the ad unit)
            $this->adstatus = trim($status);
            
            return;
            
        }
        
        public function setadDefaultStyle($style = '',$class = '')
        {
            
            //We assign the custom style and class to the global variables
            $this->teststyle = trim($style);
            $this->testclass = trim($class);
            
            return;
            
        }
        
        public function generateAdUnit($settings = array(),$status = 0)
        {
            
            //We generate variables needed for this method
            $ad_unit = '';
            $ad_code = '';
            $curr_settings = array();
            
            //We simply check to see if there are settings available
            if($settings)
            {
                
                //We determine the ad type for this ad unit. Default value is async (Responsive ad)
                $ad_type = ($settings['type']) ? trim($settings['type']) : 'async';
                
                //We determine what client ID to use. They can either assign it specifically for this ad unit or use the global value
                $ad_clientid = ($settings['clientid']) ? trim($settings['clientid']) : $this->clientid;
                
                //We get the slot ID value for this ad unit
                $ad_slotid = trim($settings['slotid']);
                
                //We get the channel ID value for this ad unit. This is not required
                $ad_channel = trim($settings['channel']);
                
                //We get the comments for this ad unit. This is not required
                $ad_comments = trim($settings['comments']);
                
                //We get the format to use for this ad unit. The options are auto, horizontal, vertical, rectangle. this is not required
                $ad_format = trim($settings['format']);
                
                //We get the custom style set for this ad unit. This is not required
                $ad_style = trim($settings['style']);
                
                //We get the custom class name set for this ad unit. This is not required
                $ad_class = trim($settings['class']);
                
                //We get the mobile value for this ad unit. The options are 0 (Do not use full width ads for mobile) and
                //1 (Make ads full width for mobile). This field is not required
                $ad_mobile = intval($settings['mobile']);
                
                //We get the value for the in script option for this ad unit. The options are 0 (Do not include the script with this ad unit
                //and 1 (Include the script with this ad unit). This field is not required
                $ad_script = intval($settings['inscript']);
                
                //We get the value for the push code option for this ad unit. The options are 0 (Do not include the push code with this ad unit
                //and 1 (Include the push code with this ad unit). This field is not required
                $ad_push = intval($settings['inpush']);
                
                //We get the Ezoic ID for this ad unit. This field is not required
                $ad_ezid = intval($settings['ezid']);
                
                //We get the Ezoic name for this ad unit. This field is not required
                $ad_ezname = trim($settings['ezname']);
                
                //We get the Ezoic place holder name for this ad unit. This field is not required
                $ad_ezplace = trim($settings['ezplace']);
            
                //We determine what status to use for the current ad unit. Either use this ad units status or the globally set status
                $curr_status = ($status) ? $status : $this->adstatus;
                
                //We generate the comments for this ad unit
                $curr_comments = $this->generateAdUnitComments($ad_comments);
                
                switch(strtolower($curr_status))
                {
                    
                    case 'none':
                        
                        //If status is set to none, then dont display any ad code, just return to main script
                        return;
                        
                    break;
                    
                    case 'test':
                        
                        //We determine what style and or class to use for this test unit
                        $ad_style = ($this->teststyle) ? ' style="' .$this->teststyle .'"' : '';
                        $ad_class = ($this->testclass) ? ' class="' .$this->testclass .'"' : '';
                        
                        //We add the comments, if present
                        $ad_unit = $curr_comments ."\n" .'<div' .$ad_style .$ad_class .'></div>' ."\n";
                        
                    break;
                    
                    case 'live':
                        
                        switch($ad_type)
                        {
                            
                            case 'async':
                                
                                //We generate any custom classes for this ad unit
                                $curr_settings[] = $this->generateAdUnitClass($ad_class);
                                
                                //We generate any custom styles for this ad unit
                                $curr_settings[] = $this->generateAdUnitStyle($ad_style);
                                
                                //We generate the current client id for this ad unit
                                $curr_settings[] = $this->generateAdClientID($ad_type,$ad_clientid);
                                
                                //We generate the current slot ID for this ad unit
                                $curr_settings[] = $this->generateAdSlotID($ad_type,$ad_slotid);
                                
                                //We generate the current channel for this ad unit
                                $curr_settings[] = $this->generateAdUnitChannel($ad_type,$ad_channel);
                                
                                //We generate the ad format for this ad unit
                                $curr_settings[] = $this->generateAdUnitFormat($ad_format);
                                
                                //We generate the mobile option for this ad unit
                                $curr_settings[] = $this->generateAdUnitMobileStyle($ad_mobile);
                                
                                //We check to see if they want to add the include file for this ad unit
                                $ad_code .= $this->generateIncludeScript($ad_type,$ad_script);
                                
                                //We now build out the code for this ad unit
                                $ad_code .= $curr_comments ."\n" .'<ins ' .implode("\n",array_filter($curr_settings)) .'></ins>' ."\n";
                                
                                //We check to see if they want to add the push script code for this ad unit
                                $ad_code .= $this->generatePushScript($ad_type,$ad_push);
                                           
                                //We see if this ad needs to be wrapped by an Ezoic ad
                                $ad_unit = $this->wrapEzoicAdUnit($ad_ezid,$ad_ezname,$ad_ezplace,$ad_code);
                                
                            break;
                            
                            case 'sync':
                                
                                //This is allows you to specify the height of this ad unit
                                //This field is not required. Only use it for synchronous ads
                                $ad_height = intval($settings['height']);
                                
                                //This is allows you to specify the width of this ad unit
                                //This field is not required. Only use it for synchronous ads
                                $ad_width = intval($settings['width']);
                                
                                //We generate the current client id for this ad unit
                                $curr_settings[] = $this->generateAdClientID($ad_type,$ad_clientid);
                                
                                //We generate the current slot ID for this ad unit
                                $curr_settings[] = $this->generateAdSlotID($ad_type,$ad_slotid);
                                
                                //We generate the current channel for this ad unit
                                $curr_settings[] = $this->generateAdUnitChannel($ad_type,$ad_channel);
                                
                                //We generate the height and width for this ad unit
                                $curr_settings[] = $this->generateAdUnitHeight($ad_height);
                                $curr_settings[] = $this->generateAdUnitWidth($ad_width);
                                
                                //We now build out the code for this ad unit
                                $ad_code = $curr_comments
                                          ."\n" .'<script type="text/javascript">'
                                          ."\n" .implode(";\n",array_filter($curr_settings)) .';'
                                          ."\n" .'</script>'
                                          ."\n";
                                
                                //We check to see if they want to add the include file for this ad unit
                                $ad_code .= $this->generateIncludeScript($ad_type,$ad_script);
                                
                                //We see if this ad needs to be wrapped by an Ezoic ad
                                $ad_unit = $this->wrapEzoicAdUnit($ad_ezid,$ad_ezname,$ad_ezplace,$ad_code);
                                
                            break;
                            
                        }
                        
                    break;
                    
                }
                
            }
            
            return $ad_unit;
            
        }
        
        public function generateIncludeScript($type = 'async',$script = 1)
        {
            
            //We generated variables needed for this method
            $include_script = '';
            
            //We determine what attribute to use
            $type_attr = ($type == 'async') ? ' async ' : ' ';
            
            //We determine what JS file to include
            $type_file = ($type == 'async') ? 'js/adsbygoogle.js' : 'show_ads.js';
            
            //We check to see if they want to include the script now
            if($script)
            {

                  
                //We generate the script to include based on the type of ad unit they are building
                $include_script = "\n" .'<script' .$type_attr .'src="//pagead2.googlesyndication.com/pagead/' .$type_file .'"></script>' ."\n";                    
                
            }
            
            return $include_script;
            
        }
        
        public function generatePushScript($type = 'async',$script = 1)
        {
            
            //We generated variables needed for this method
            $push_script = '';
            
            //We determine if they want to add the push script
            if($script)
            {
            
                switch(strtolower($type))
                {
                    
                    case 'async':
                        
                        //We generate the push script needed for a responsive ad only
                        $push_script = "\n" .'<script>(adsbygoogle = window.adsbygoogle || []).push({});</script>' ."\n";
                        
                    break;
                        
                }
                
            }
            
            return $push_script;
            
        }
        
        private function generateAdClientID($type,$clientid)
        {
            
            //We determine the variable needed based off the type of ad unit they are building
            $clientid_var = ($type == 'async') ? 'data-ad-client' : 'google_ad_client';
            
            return ($clientid) ? $clientid_var .'="' .$clientid .'"' : '';
            
        }
        
        private function generateAdSlotID($type,$slotid)
        {
            
            //We determine the variable needed based off the type of ad unit they are building
            $slotid_var = ($type == 'async') ? 'data-ad-slot' : 'google_ad_slot';
            
            return ($slotid) ? $slotid_var .'="' .$slotid .'"' : '';
            
        }
        
        private function generateAdUnitChannel($type,$channel)
        {
            
            //We determine the variable needed based off the type of ad unit they are building
            $channel_var = ($type == 'async') ? 'my_google_ad_channel' : 'google_ad_channel';
            
            return ($channel) ? $channel_var .'="' .$channel .'"' : '';
        
        }
        
        private function generateAdUnitComments($comments)
        {
            
            //We return the comments for this ad unit
            return ($comments) ? "\n" .'<!-- ' .$comments .' -->' : '';
            
        }
        
        private function generateAdUnitFormat($format)
        {
            
            //This lists all available formats
            $formats = array('auto','horizontal','vertical','rectangle');
            
            //We return the format for this ad unit
            return (in_array(strtolower($format),$formats)) ? 'data-ad-format="' .$format .'"' : '';
            
        }
        
        private function generateAdUnitStyle($style)
        {
            
            //We return the style for this ad unit
            return (!$style) ? 'style="display:block;"' : 'style="' .$style .'"';
            
        }
        
        private function generateAdUnitClass($class)
        {
            
            //We generate the value for this custom class
            $custom_class = ($class) ? ' ' .$class : '';
            
            //We return the class for this ad unit
            return 'class="adsbygoogle' .$custom_class .'"';
            
        }
        
        private function generateAdUnitMobileStyle($mobile)
        {
            
            //We generate the value for mobile styling
            $mobile_value = ($mobile) ? 'true' : 'false';
            
            //We return the mobile style for this ad unit
            return ($mobile) ? 'data-full-width-responsive="' .$mobile_value .'"' : '';
            
        }
        
        private function generateAdUnitWidth($width)
        {
            
            //We return the width for this ad unit
            return ($width) ? 'google_ad_width=' .$width : '';
            
        }
        
        private function generateAdUnitHeight($height)
        {
            
            //We return the width for this ad unit
            return ($height) ? 'google_ad_height=' .$height : '';
            
        }
        
        private function wrapEzoicAdUnit($ezid,$ezname,$ezplace,$adunit)
        {
            
            //We generate variables needed for this method
            $ezoic_wrapper = '';
            
            //We check to see if there is an Ezoic ID
            if($ezid)
            {
                
                //We add the Ezoic wrapper code for this ad unit
                $ezoic_wrapper = "\n" .'<!-- Ezoic - ' .$ezname .' - ' .$ezplace .' -->'
                                ."\n" .'<div id="ezoic-pub-ad-placeholder-' .$ezplace .'">'
                                ."\n" .$adunit
                                ."\n" .'</div>'
                                ."\n" .'<!-- End Ezoic - ' .$ezname .' - ' .$ezplace .' -->'
                                ."\n";
                
                return $ezoic_wrapper;
                    
            }else
            {
                
                //If no Ezoic ID, we simply return the ad unit code
                return $adunit;
                
            }
            
        }
        
    }
    
?>
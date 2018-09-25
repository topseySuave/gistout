<?php

/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 5/23/2017
 * Time: 8:25 PM
 */
require_once "call.php";

class advertise
{
    public $ads_url = 'gist_ads?transform=1';

    public function __construct(){}

    private function get($id, $adId, $pos, $link, $img, $provider, $startDate, $endDate, $flag)
    {
        global $call_url;
        if($id != null)
        {
            $extra = $this->ads_url.'&filter=id,eq,'.$id;
            $url = $call_url.$extra;
            $response = call('GET',$url);
            return $response;
        }

        if($adId != null)
        {
            $extra = $this->ads_url.'&filter=ad_id,eq,'.$adId;
            $url = $call_url.$extra;
            $response = call('GET',$url);
            return $response;
        }

        if($pos != null)
        {
            $extra = $this->ads_url.'&filter=position,eq,'.$pos;
            $url = $call_url.$extra;
            $response = call('GET',$url);
            return $response;
        }

        if($link != null)
        {
            $extra = $this->ads_url.'&filter=href,eq,'.$link;
            $url = $call_url.$extra;
            $response = call('GET',$url);
            return $response;
        }

        if($img != null)
        {
            $extra = $this->ads_url.'&filter=image,eq,'.$img;
            $url = $call_url.$extra;
            $response = call('GET',$url);
            return $response;
        }

        if($provider != null)
        {
            $extra = $this->ads_url.'&filter=provider,eq,'.$provider;
            $url = $call_url.$extra;
            $response = call('GET',$url);
            return $response;
        }

        if($startDate != null)
        {
            $extra = $this->ads_url.'&filter=duration-start,eq,'.$startDate;
            $url = $call_url.$extra;
            $response = call('GET',$url);
            return $response;
        }

        if($endDate != null)
        {
            $extra = $this->ads_url.'&filter=duration-end,eq,'.$endDate;
            $url = $call_url.$extra;
            $response = call('GET',$url);
            return $response;
        }

        if($flag != null)
        {
            $extra = $this->ads_url.'&filter=active_flag,eq,'.$flag;
            $url = $call_url.$extra;
            $response = call('GET',$url);
            return $response;
        }
    }

    public function getById($id)
    {
        return $this->get($id, null, null, null, null, null, null, null, null);
    }

    public function getByAdId($id)
    {
        return $this->get(null, $id, null, null, null, null, null, null, null);
    }

    public function getByPosition($pos)
    {
        return $this->get(null, null, $pos, null, null, null, null, null, null);
    }

    public function getByHref($link)
    {
        return $this->get(null, null, null, $link, null, null, null, null, null);
    }

    public function getByImage($img)
    {
        return $this->get(null, null, null, null, $img, null, null, null, null);
    }

    public function getByProvider($provider)
    {
        return $this->get(null, null, null, null, null, $provider, null, null, null);
    }

    public function getByStartDate($date)
    {
        return $this->get(null, null, null, null, null, null, $date, null, null);
    }

    public function getByEndDate($date)
    {
        return $this->get(null, null, null, null, null, null, null, $date, null);
    }

    public function getByActiveFlag()
    {
        return $this->get(null, null, null, null, null, null, null, null, 1);
    }

    public function getAll()
    {
        global $call_url;

        $extra = $this->ads_url;
        $url = $call_url.$extra;
        $response = call('GET',$url);

        if ($response != null)
            return $response;
        else
            return 'Error Occurred!!';
    }

    public function addNew($adId, $href, $image, $provider, $date, $startDate, $endDate, $position = false)
    {
        if ($href == null || $image == null || $provider == null)
        {
            return 'Enter Appropriate values..!!';
        }
        else
        {
            global $call_url;
            $url = $call_url.'gist_ads';
            if($position){
                $obj = '{
                    "ad_id": '.$adId.',
                    "position": "'.$position.'",
                    "href": "'.$href.'",
                    "image": "'.$image.'",
                    "provider": "'.$provider.'",
                    "date": '.$date.',
                    "duration-start": '.$startDate.',
                    "duration-end": '.$endDate.'
                    }';
            }else{
                $obj = '{
                    "ad_id": '.$adId.',
                    "href": "'.$href.'",
                    "image": "'.$image.'",
                    "provider": "'.$provider.'",
                    "date": '.$date.',
                    "duration-start": '.$startDate.',
                    "duration-end": '.$endDate.'
                }';
            }
            $response = call('POST', $url, $obj);
            return $response;
        }
    }

    private function update($id, $href, $image, $provider, $position, $startDate, $endDate)
    {
        global $call_url;
        if($href != null)
        {
            $url = $call_url.'gist_ads/'.$id;
            $obj = '{"href": '.$href.'}';
            $response = call('PUT', $url, $obj);
            return $response;
        }

        if($image != null)
        {
            $url = $call_url.'gist_ads/'.$id;
            $obj = '{"image": '.$image.'}';
            $response = call('PUT', $url, $obj);
            return $response;
        }

        if($provider != null)
        {
            $url = $call_url.'gist_ads/'.$id;
            $obj = '{"provider": '.$provider.'}';
            $response = call('PUT', $url, $obj);
            return $response;
        }

        if($position != null)
        {
            $url = $call_url.'gist_ads/'.$id;
            $obj = '{"position": '.$position.'}';
            $response = call('PUT', $url, $obj);
            return $response;
        }

        if($startDate != null)
        {
            $url = $call_url.'gist_ads/'.$id;
            $obj = '{"duration-start": '.$startDate.'}';
            $response = call('PUT', $url, $obj);
            return $response;
        }

        if($endDate != null)
        {
            $url = $call_url.'gist_ads/'.$id;
            $obj = '{"duration-end": '.$endDate.'}';
            $response = call('PUT', $url, $obj);
            return $response;
        }
    }

    /**
     * @return string $ads_url
     */
    public function updateHref($id, $ads_url)
    {
        return $this->update($id, $ads_url, null, null, null, null, null);
    }

    /**
     * @return string $image
     */
    public function updateImage($id, $image)
    {
        return $this->update($id, null, $image, null, null, null, null);
    }

    /**
     * @return string $provider
     */
    public function updateProvider($id, $provider)
    {
        return $this->update($id, null, null, $provider, null, null, null);
    }

    /**
     * @return string $position
     */
    public function updatePosition($id, $position)
    {
        return $this->update($id, null, null, null, $position, null, null);
    }

    /**
     * @return string $position
     */
    public function updateStartDate($id, $date)
    {
        return $this->update($id, null, null, null, null, $date, null);
    }

    /**
     * @return string $position
     */
    public function updateEndDate($id, $date)
    {
        return $this->update($id, null, null, null, null, null, $date);
    }

    /**
     * @return string $position
     */
    public function updateActiveFlag($id, $val)
    {
        global $call_url;
        $url = $call_url.'gist_ads/'.$id;
        $obj = '{"active_flag": '.$val.'}';
        $response = call('PUT', $url, $obj);
        return $response;
    }
}
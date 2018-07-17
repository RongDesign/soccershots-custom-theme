<?php
/*
  LatLng: Single Latitude/Longitude
  LatLngBounds: Bounding Box of multiple Latitude/Longitude

  Based on Leaflet:
  https://github.com/Leaflet/Leaflet/blob/f61e2f4a7be27937e76348dd012a2f3be9712f05/src/geo/LatLngBounds.js
*/

namespace geo;

class LatLng
{
  public $lat;
  public $lng;

  public function __construct($lat, $lng)
  {
    $this->lat = $lat;
    $this->lng = $lng;
  }
}

class LatLngBounds
{
  public $southWest;
  public $northEast;

  public function extend(LatLng $point) {
    $sw = $this->southWest;
    $ne = $this->northEast;

    $sw2 = $point;
    $ne2 = $point;

    if (!isset($sw) && !isset($ne)) {
      $this->southWest = new LatLng($sw2->lat, $sw2->lng);
      $this->northEast = new LatLng($ne2->lat, $ne2->lng);
    } else {
      $sw->lat = min($sw2->lat, $sw->lat);
      $sw->lng = min($sw2->lng, $sw->lng);
      $ne->lat = max($ne2->lat, $ne->lat);
      $ne->lng = max($ne2->lng, $ne->lng);
    }

    return $this;
  }

  public function getCenter()
  {
    return new LatLng(
      ($this->southWest->lat + $this->northEast->lat) / 2,
      ($this->southWest->lng + $this->northEast->lng) / 2
    );
  }
}
?>

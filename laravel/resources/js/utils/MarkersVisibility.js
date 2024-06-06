const hideMarker = (id) => {
    let markers = document.querySelectorAll('.leaflet-marker-icon');
    markers.forEach((marker, index) => {
      if (index === id) {
        // marker.style.backgroundColor = '#754043';
      } else {
        marker.style.display = 'none';
      }
    });
  }
  
  const showMarker = () => {
    let markers = document.querySelectorAll('.leaflet-marker-icon');
    markers.forEach((marker) => {
      marker.style.display = 'block';
    });
    console.log('showMarker');
  }

  export { hideMarker, showMarker };
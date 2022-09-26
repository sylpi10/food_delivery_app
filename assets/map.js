let map = L.map('map').setView([
    51.505, 0
    ], 13);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'}).addTo(map);


  async function loadRestaurants() {
    const response = await fetch('https://127.0.0.1:8000/api/restaurants',{
        headers: {
        method: 'GET',
            'Accept': 'application/json'
          }
    });
    const restaurants = await response.json();
    let marker;
    restaurants.map((r) => {
        if (r.lattitude && r.longitude) {
            marker = L.marker([r.lattitude, r.longitude]).addTo(map).bindPopup(r.description).openPopup();
            console.log(r.lattitude, r.longitude);
        }
    })
}
loadRestaurants();
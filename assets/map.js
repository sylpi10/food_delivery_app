let lat = 0.156967;
let long = 47.336761;
let zoom = 6;
let map = L.map('map').setView([
    lat, long
    ], zoom);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(map);

//   async function loadRestaurants() {
//     const response = await fetch('https://127.0.0.1:8000/api/restaurants',{
//         headers: {
//         method: 'GET',
//             'Accept': 'application/json'
//           }
//     });
//     const restaurants = await response.json();
//     let marker;
//     restaurants.map((r) => {
//         if (r.lattitude && r.longitude) {
//             marker = L.marker([r.lattitude, r.longitude]).addTo(map).bindPopup(r.description).openPopup();
//             console.log(r.lattitude, r.longitude);
//         }
//     })
// }
// loadRestaurants();

const searchBtn = document.querySelector('#searchBtn');
const address = document.querySelector('#address').value;
searchBtn.addEventListener('click', (e) =>{
    e.preventDefault();
    fetchResto();
});

async function fetchResto() {
    const url = `https://api-adresse.data.gouv.fr/search/?q=${address}`;
    const apiResto = await fetch(url, {
        headers: {
                'Accept': 'application/json'
              }
            });
            zoom = 5;
            const resto = await apiResto.json();
            resto.features.map((r, index) => {
                if (index === 0) {
                    lat = r.geometry.coordinates[0];
                    long = r.geometry.coordinates[0]
                }
                x = r.geometry.coordinates[0];
                y = r.geometry.coordinates[1];
                marker = L.marker([x, y]).addTo(map).bindPopup(r.properties.label).openPopup();
                window.location = `https://127.0.0.1:8000/api/restaurants/${x}/${y}`;  
            })
          
}
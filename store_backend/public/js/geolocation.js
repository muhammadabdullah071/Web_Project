/**
 * FoodDash Geolocation System
 */
document.addEventListener('DOMContentLoaded', function() {
    const cityDisplay = document.getElementById('user-city-display');
    const locationStatus = document.getElementById('location-status');

    if (!cityDisplay) return;

    // Check if city is already in session (via meta tag or server-side)
    const currentCity = document.querySelector('meta[name="user-city"]')?.content;
    
    if (!currentCity || currentCity === 'Detecting...') {
        detectLocation();
    }

    function detectLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                async (position) => {
                    const { latitude, longitude } = position.coords;
                    
                    // In production, use Google Maps Reverse Geocoding:
                    // https://maps.googleapis.com/maps/api/geocode/json?latlng=${latitude},${longitude}&key=YOUR_API_KEY
                    
                    // For demo/FYP, we'll mock a city name based on common coordinates
                    // (Or you can use a free service like bigdatacloud)
                    try {
                        const response = await fetch(`https://api.bigdatacloud.net/data/reverse-geocode-client?latitude=${latitude}&longitude=${longitude}&localityLanguage=en`);
                        const data = await response.json();
                        const city = data.city || data.locality || "Islamabad";
                        
                        updateServerLocation(city, latitude, longitude);
                    } catch (error) {
                        console.error("Geocoding failed", error);
                        updateServerLocation("Islamabad", latitude, longitude);
                    }
                },
                (error) => {
                    console.warn("Location permission denied", error);
                    updateServerLocation("Islamabad"); // Fallback
                }
            );
        } else {
            updateServerLocation("Islamabad");
        }
    }

    function updateServerLocation(city, lat = null, lng = null) {
        fetch('/location/set-city', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ city, lat, lng })
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                cityDisplay.innerText = data.city;
                if (locationStatus) locationStatus.style.display = 'none';
                
                // Optional: Reload if city changed and we need to refresh restaurants
                // window.location.reload();
            }
        });
    }
});

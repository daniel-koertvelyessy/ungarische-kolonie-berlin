import './bootstrap';
import.meta.glob([
    '../images/**',
    '../images/favicons/**',
])




    document.addEventListener("navigate-to", function (event) {
        console.log("Event received:", event.detail); // Debugging
        const url = event.detail;

        if (window.Livewire && Livewire.navigate) {
            console.log("Navigating via Livewire.navigate:", url);
            Livewire.navigate(url);
        } else {
            console.log("Navigating via window.location.href:", url);
            window.location.href = url; // Fallback
        }
    });


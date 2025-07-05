<!-- Back To Top Button -->
<button id="backToTopBtn"
    class="hidden fixed bottom-3 right-3 z-50 animate-bounce text-white p-3 rounded-full bg-blue-600 shadow-xl"
    onclick="scrollToTop()" aria-label="Scroll to top">
    <svg xmlns="http://www.w3.org/2000/svg" fill="white" width="24" height="24" viewBox="0 0 24 24">
        <path d="M0 0h24v24H0z" fill="none" />
        <path d="M4 12l1.41 1.41L11 7.83v11.17h2V7.83l5.59 5.58L20 12l-8-8-8 8z" />
    </svg>
</button>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const backToTopBtn = document.getElementById("backToTopBtn");

        window.addEventListener("scroll", function() {
            if (window.scrollY > 400) {
                backToTopBtn.classList.remove("hidden");
            } else {
                backToTopBtn.classList.add("hidden");
            }
        });
    });

    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    }
</script>

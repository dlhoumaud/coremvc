app.component("carousel-indicators", {
    props: ["count", "id"],
    template: `<div class="carousel-indicators">
    <button 
        v-for="n in count" 
        :key="n" 
        type="button" 
        :data-bs-target="'#' + id" 
        :data-bs-slide-to="n - 1" 
        :class="{ active: n === 1 }" 
        :aria-current="n === 1 ? 'true' : null"
        :aria-label="'Slide ' + n">
    </button>
</div>`,
});
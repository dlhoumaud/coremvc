export default (app) => {
    app.component('modal-confirm', {
        props: ['id', 'idlabel', 'title', 'titlecolor', 'message', 'ok', 'okid', 'okhref', 'okicon', 'okcolor', 'cancel', 'cancelicon', 'cancelcolor'],
        template: `<div class="modal fade" :id="id" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" :aria-labelledby="idlabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen-sm-down" >
        <div class="modal-content">
            <div class="modal-header">
                <h1 :class="['modal-title', 'fs-5', titlecolor]" :id="idlabel">{{ title }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <slot name="message">{{ message }}</slot>
                <div class="btn-group w-100 py-2" role="group" aria-label="Model footer buttons">
                    <a :class="['btn', okcolor]" :id="okid" :href="okhref" @click="okclick" @mouseenter="okmouseenter" @mouseleave="okmouseleave"><i :class="['fas',okicon]"></i>{{ ok }}</a>
                    <button type="button" :class="['btn', cancelcolor]" data-bs-dismiss="modal"><i :class="['fas',cancelicon]"></i>{{ cancel }}</button>
                </div>
            </div>
        </div>
    </div>
</div>`
    });
}
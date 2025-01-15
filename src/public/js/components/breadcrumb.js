export default (app) => {
    app.component("breadcrumb", {
        props: {
            fields: {
                type: Array,
                required: true,
            }
        },
        template: `
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li v-for="field in fields" :key="field.id" :class="['breadcrumb-item', field.class]"><a :href="field.link"><i :class="['fa-solid', field.icon, field.iconcolor]"></i>{{ field.text }}</a></li>
                </ol>
            </nav>
        `,
    });
};

export default (app) => {
    app.component("input-floating", {
        props: {
            fields: {
                type: Array,
                required: true, // Les champs sont obligatoires
                // Exemple de structure attendue pour `fields`:
                // [
                //   { id: "password", name: "password", type: "password", label: "Mot de passe" },
                //   { id: "email", name: "email", type: "email", label: "Email" },
                // ]
            },
            mb: {
                type: String,
                default: "mb-3", // Classe par défaut pour la marge
            },
        },
        template: `
            <div v-for="field in fields" :key="field.id" :class="['form-floating', mb]">
                <input 
                    :type="field.type" 
                    class="form-control" 
                    :name="field.name" 
                    :id="field.id" 
                    :placeholder="field.placeholder"
                    :value="field.value"
                    :required="field.required"
                >
                <label :for="field.id">{{ field.placeholder }}</label>
            </div>
        `,
    });
};

export default (app) => {
    app.component("typewriter", {
      props: {
        content: {
          type: String,
          required: true
        },
        box: {
          type: String,
          default: "div"
        },
        speed: {
          type: Number,
          default: 100
        }
      },
      template: `
        <component :is="box" ref="typewriterText" v-html="typedContent"></component>
      `,
      data() {
        return {
          typedContent: ""
        };
      },
      mounted() {
        this.startTypingEffect();
      },
      methods: {
        startTypingEffect() {
          let index = 0;
          const text = this.content;

          const typeCharacter = () => {
            if (index < text.length) {
              this.typedContent += text[index]; // Ajoute progressivement le texte avec HTML
              index++;
              setTimeout(typeCharacter, this.speed);
            }
          };

          typeCharacter();
        }
      }
    });
};

class RexLink extends HTMLInputElement {

    static get observedAttributes() {return ['article-name','article-id'];}

    constructor() {
        super();
        this._shadow = this.attachShadow({mode: 'open'});

        // this.rexVar = this.getAttribute('rex-var');
        this.rexVar = 2;

        this.inputArticleName = document.createElement('input');
        this.inputArticleName.setAttribute('readonly', 'readonly');
        this.inputArticleName.setAttribute('type', 'text');
        this._shadow.appendChild(this.inputArticleName);


        this.inputArticleId = document.createElement('input');
        this.inputArticleId.setAttribute('type', 'hidden');
        this.inputArticleId.setAttribute('name', `REX_INPUT_LINK[${this.rexVar}]`);
        this._shadow.appendChild(this.inputArticleId);
    }

    connectedCallback() {

    }

    disconnectedCallback() {

    }

    attributeChangedCallback(attr, oldValue, newValue) {
        if(attr === 'article-name') {
            this.inputArticleName.value = newValue || '';
        }
        if(attr === 'article-id') {
            this.inputArticleId.value = newValue || '';
        }
    }

    adoptedCallback(oldDocument, newDocument) {

    }
}

customElements.define('rex-link', RexLink);
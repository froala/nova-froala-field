class FroalaAttachmentsAdapter {
    constructor(resource, field) {
        this.resource = resource;
        this.field = field;
    }

    get cleanUpUrl() {
        return `/nova-vendor/froala-field/${this.resource}/attachments/${this.field.attribute}/${
            this.field.draftId
        }`;
    }

    get imageUploadUrl() {
        return `/nova-vendor/froala-field/${this.resource}/attachments/${this.field.attribute}`;
    }

    get imageRemoveUrl() {
        return this.imageUploadUrl;
    }

    get vieoUploadUrl() {
        return this.imageUploadUrl;
    }

    get fileUploadUrl() {
        return this.imageUploadUrl;
    }
}

export default FroalaAttachmentsAdapter;

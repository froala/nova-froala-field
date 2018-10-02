class TrixAttachmentsAdapter {
    constructor(resource, field) {
        this.resource = resource;
        this.field = field;
    }

    get cleanUpUrl() {
        return `/nova-api/${this.resource}/trix-attachment/${this.field.attribute}/${
            this.field.draftId
        }`;
    }

    get imageUploadUrl() {
        return `/nova-api/${this.resource}/trix-attachment/${this.field.attribute}`;
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

export default TrixAttachmentsAdapter;

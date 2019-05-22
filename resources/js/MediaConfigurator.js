import TrixAttachmentsAdapter from './TrixAttachmentsAdapter';
import FroalaAttachmentsAdapter from './FroalaAttachmentsAdapter';

class MediaConfigurator {
    constructor(resource, field, notificator) {
        this.resource = resource;
        this.field = field;

        this.notificator = notificator;

        this.adapter = this._buildAdapter(this.field.attachmentsDriver);
        this._token = document.head.querySelector('meta[name="csrf-token"]').content;
    }

    _buildAdapter(mode) {
        switch (mode) {
            case 'trix':
                return new TrixAttachmentsAdapter(this.resource, this.field);
            case 'froala':
                return new FroalaAttachmentsAdapter(this.resource, this.field);
            default:
                return new FroalaAttachmentsAdapter(this.resource, this.field);
        }
    }

    getConfig() {
        return _.merge(
            this.uploadConfig,
            this.eventsConfig,
            this.imageManagerLoadConfig,
            this.imageManagerDeleteConfig,
            this.videoUploadConfig,
            this.fileUplaodConfig
        );
    }

    /**
     * Purge pending attachments for the draft
     */
    cleanUp() {
        if (this.field.withFiles) {
            Nova.request()
                .delete(this.adapter.cleanUpUrl)
                .then(response => {})
                .catch(error => {
                    this.notificator.show(error.message, { type: 'error' });
                });
        }
    }

    get uploadConfig() {
        return {
            // Set the image upload parameter.
            imageUploadParam: 'attachment',

            // Set the image upload URL.
            imageUploadURL: this.adapter.imageUploadUrl,

            // Additional upload params.
            imageUploadParams: {
                _token: this._token,
                draftId: this.field.draftId,
            },

            // Set request type.
            imageUploadMethod: 'POST',
        };
    }

    get eventsConfig() {
        return {
            events: {
                'froalaEditor.image.removed': (e, editor, $img) => {
                    Nova.request()
                        .delete(this.adapter.imageRemoveUrl, {
                            params: { attachmentUrl: $img.attr('src') },
                        })
                        .then(response => {})
                        .catch(error => {
                            this.notificator.show(error.message, { type: 'error' });
                        });
                },
                'froalaEditor.image.error': (e, editor, error, response) => {
                    try {
                        response = JSON.parse(response);

                        if (typeof response.status !== 'undefined' && response.status === 409) {
                            this.notificator.show('A file with this name already exists.', {
                                type: 'error',
                            });

                            return;
                        }
                    } catch (e) {}

                    this.notificator.show(error.message, { type: 'error' });
                },
                'froalaEditor.imageManager.error': (e, editor, error, response) => {
                    this.notificator.show(error.message, { type: 'error' });
                },
                'froalaEditor.file.error': (e, editor, error, response) => {
                    this.notificator.show(error.message, { type: 'error' });
                },
            },
        };
    }

    get imageManagerLoadConfig() {
        return {
            imageManagerLoadURL: `/nova-vendor/froala-field/${this.resource}/image-manager`,

            imageManagerLoadParams: {
                field: this.field.attribute,
            },
        };
    }

    get imageManagerDeleteConfig() {
        return {
            imageManagerDeleteURL: `/nova-vendor/froala-field/${this.resource}/image-manager`,

            imageManagerDeleteMethod: 'DELETE',

            imageManagerDeleteParams: {
                _token: this._token,
                field: this.field.attribute,
            },
        };
    }

    get videoUploadConfig() {
        return {
            videoUploadURL: this.adapter.vieoUploadUrl,

            videoUploadParam: 'attachment',

            videoUploadParams: {
                _token: this._token,
                draftId: this.field.draftId,
            },
        };
    }

    get fileUplaodConfig() {
        return {
            // Set the file upload parameter.
            fileUploadParam: 'attachment',

            // Set the file upload URL.
            fileUploadURL: this.adapter.fileUploadUrl,

            // Additional upload params.
            fileUploadParams: {
                _token: this._token,
                draftId: this.field.draftId,
            },

            // Set request type.
            fileUploadMethod: 'POST',
        };
    }
}

export default MediaConfigurator;

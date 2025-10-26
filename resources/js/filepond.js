import { FilePond, registerPlugin } from 'filepond';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size';

// Import FilePond styles (Vite will include them)
import 'filepond/dist/filepond.min.css';
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css';

registerPlugin(FilePondPluginImagePreview, FilePondPluginFileValidateType, FilePondPluginFileValidateSize);

document.addEventListener('DOMContentLoaded', () => {
    // Initialize FilePond for input elements named 'filename'
    const fileInputs = document.querySelectorAll('input[type="file"][name="filename"]');

    fileInputs.forEach((input) => {
        FilePond.create(input, {
            allowMultiple: false,
            acceptedFileTypes: ['image/*'],
            maxFileSize: '2MB',
            labelIdle: 'Tarik & lepas gambar atau <span class="filepond--label-action">Pilih</span>'
        });
    });
});

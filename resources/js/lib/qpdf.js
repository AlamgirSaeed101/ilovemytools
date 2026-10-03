import { t } from './i18n.js';

// Adding and removing a real "open password" with QPDF (Apache-2.0) compiled to WASM
// (https://github.com/neslinesli93/qpdf-wasm). Runs fully in the browser: the PDF never
// leaves the device. The ~1.3 MB .wasm binary is fetched from jsDelivr instead of being
// bundled, the same pattern `bgRemoval.js` uses for its large model/runtime files.
const QPDF_VERSION = '0.3.0';
const QPDF_WASM_URL = `https://cdn.jsdelivr.net/npm/@neslinesli93/qpdf-wasm@${QPDF_VERSION}/dist/qpdf.wasm`;

async function runQpdf(args, inputBytes) {
    const { default: createQpdfModule } = await import('@neslinesli93/qpdf-wasm');
    const module = await createQpdfModule({
        noInitialRun: true,
        locateFile: () => QPDF_WASM_URL,
        print: () => {},
        printErr: () => {},
    });
    module.FS.writeFile('/in.pdf', inputBytes);
    const code = module.callMain(args);
    return { module, code };
}

/** Add an open password (AES-256 encryption) to an unprotected PDF. `bytes` must already be a valid, unencrypted PDF. */
export async function encryptPdf(bytes, password) {
    const { module, code } = await runQpdf(['--encrypt', password, password, '256', '--', '/in.pdf', '/out.pdf'], bytes);
    if (code !== 0) throw new Error(t('Could not protect this PDF. It may be damaged or not a real PDF.'));
    return module.FS.readFile('/out.pdf');
}

/** Remove the open password from a PDF that is already confirmed to be encrypted. Throws on a wrong password. */
export async function decryptPdf(bytes, password) {
    const { module, code } = await runQpdf(['--decrypt', `--password=${password}`, '--', '/in.pdf', '/out.pdf'], bytes);
    if (code !== 0) throw new Error(t('Incorrect password. Please try again.'));
    return module.FS.readFile('/out.pdf');
}

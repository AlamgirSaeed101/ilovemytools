// Usage: node ssh-put.cjs <local> <remote> [<local> <remote> ...]   (SFTP upload)
const { Client } = require('ssh2');
const pairs = process.argv.slice(2);
const c = new Client();
c.on('ready', () => c.sftp(async (err, sftp) => {
  if (err) { console.error(err.message); process.exit(1); }
  for (let i = 0; i < pairs.length; i += 2) {
    await new Promise((res, rej) => sftp.fastPut(pairs[i], pairs[i + 1], (e) => (e ? rej(e) : res())));
    console.log('uploaded', pairs[i + 1]);
  }
  c.end();
})).on('error', (e) => { console.error('SSH error:', e.message); process.exit(1); })
  .connect({ host: process.env.SSH_HOST, port: +process.env.SSH_PORT, username: process.env.SSH_USER, password: process.env.SSH_PASS, readyTimeout: 30000 });

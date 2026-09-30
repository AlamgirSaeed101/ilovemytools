// Usage: node ssh-run.cjs "<command>"   (credentials from env: SSH_HOST, SSH_PORT, SSH_USER, SSH_PASS)
// SSH_STDIN (optional) is written to the command's stdin, so secrets never appear in `ps` or logs.
const { Client } = require('ssh2');
const cmd = process.argv[2];
const c = new Client();
c.on('ready', () => {
  c.exec(cmd, (err, stream) => {
    if (err) { console.error(err.message); process.exit(1); }
    stream.on('close', (code) => { c.end(); process.exit(code ?? 0); })
      .on('data', (d) => process.stdout.write(d))
      .stderr.on('data', (d) => process.stderr.write(d));
    stream.end(process.env.SSH_STDIN ? process.env.SSH_STDIN + '\n' : '');
  });
}).on('error', (e) => { console.error('SSH error:', e.message); process.exit(1); })
  .connect({ host: process.env.SSH_HOST, port: +process.env.SSH_PORT, username: process.env.SSH_USER, password: process.env.SSH_PASS, readyTimeout: 30000 });

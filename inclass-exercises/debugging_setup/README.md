# WEB-250 — Debugging Setup

**This README is your graded debugging notebook.** Complete the TODOs below with your **own** observations after using VS Code + Xdebug. Do not paste `phpinfo()` output or anything confidential.

## Local setup

- Operating system and local server (Mac/MAMP or Windows/XAMPP): TODO mamp
- PHP version shown in the **browser's phpinfo**: TODO 13.7.2
- Xdebug version: TODO 
- Active `php.ini` path (no secrets): TODO 
- Xdebug / VS Code port (recommended 9003): TODO 9003
- Local Apache port (our class uses 55000): TODO 55000
- Mac/MAMP FastCGI `-idle-timeout 600` configured? (Windows: N/A): TODO 600
- Mac/MAMP 45-second breakpoint pause, Step Over, Continue test result (Windows: N/A): TODO 
- Local exercise index URL: TODO http://localhost:8888/web-250/inclass-exercises/debugging_setup/sandbox/sandbox_breakpoints.php
- Hosted exercise index URL: TODO

## Exercise 01 — Variables and Watch

- Prediction for `$observations` before the `+=` line: TODO before=3 after =5
- Value before Step Over: TODO observation = 3 
- Value after Step Over: TODO  observation = 5
- What you learned about the breakpoint and Watch: TODO It tells you the current value of each variable beside based on were its breaking. 
- Screenshot: `evidence/01_variables.png` — TODO caption check

## Exercise 02 — Loop and conditional breakpoint

- Predicted total and average: TODO  10 
- `$total` after the first two iterations: TODO 6 
- Values seen when `$dayIndex === 2` (index, count, total): TODO index = 2 count = 1 total= 6 
- Why the conditional breakpoint helped: TODO  it added a condition to break it. 
- Screenshot: `evidence/02_conditional.png` — TODO caption

## Exercise 03 — Step Into / Step Out / Call Stack

- Predicted output: TODO Eastern Towhee: 2 sightings   
- Which function called `formatObservation()`?: TODO  describe bird
- What Step Into showed that Step Over would skip: TODO I have no Idea, this whole document is written for someone who already knows how this system works. 
- Where Step Out returned you: TODO Again, no Idea. I dont even understand conceptually what im doing in these. 
- Screenshot: `evidence/03_call_stack.png` — TODO caption

## Exercise 04 — Find and fix the bug

- Original incorrect browser output: TODO birds counted: 4 
- Values you observed while stepping through the loop: TODO total = 0 count = 2
- Original error and minimal correction (in your words): TODO it should say += 
- Corrected output: TODO 9 
- Why PHP did not raise an exception: TODO because its a logic error not an operation error. 
- Screenshot: `evidence/04_fixed_bug.png` — TODO caption

## How to view this project

- Local: Open `web250/debugging_setup/index.php` through your MAMP/XAMPP browser URL.
- Webhost: Open the course index and follow the Debugging Setup link.
- GitHub: Link to this folder on `main` in the Moodle Comments area.

**Safety reminder:** Never commit or deploy `php.ini`, `_local_phpinfo.php`, credentials, or logs. The project-level `.vscode/launch.json`, this README, and evidence screenshots belong on **GitHub** but **not** on the public webhost. Never activate Xdebug on your public webhost.

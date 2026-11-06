# MANU HOSTING - LICENSES & THIRD-PARTY NOTICES

## Project License

**MANU HOSTING** is proprietary software. All rights reserved.

Unauthorized copying, distribution, modification, or use of this software,
in whole or in part, is strictly prohibited without prior written permission
from the copyright holder.

Copyright (c) 2026 Manu Hosting. All rights reserved.

---

## Third-Party Licenses

This project includes the following third-party components, each with their own licenses:

### PHP Dependencies (composer.json)

| Package | Version | License | Repository |
|---------|---------|---------|------------|
| cboden/ratchet | ^0.4.4 | MIT | https://github.com/ratchetphp/Ratchet |
| react/socket | ^1.12 | MIT | https://github.com/reactphp/socket |
| react/event-loop | ^1.5 | MIT | https://github.com/reactphp/event-loop |
| phpunit/phpunit | ^10.5 | BSD-3-Clause | https://github.com/sebastianbergmann/phpunit |

### JavaScript (No package manager - vanilla JS)

All JavaScript code in `public/assets/js/` is original work by Manu Hosting.

### CSS (No package manager - original)

All CSS code in `public/assets/css/` is original work by Manu Hosting.

### .NET 8 Dependencies (ManuHostingAgent.csproj)

| Package | Version | License | Repository |
|---------|---------|---------|------------|
| Microsoft.Extensions.Hosting.WindowsServices | 8.0.1 | MIT | https://github.com/dotnet/runtime |
| Microsoft.Extensions.Hosting | 8.0.1 | MIT | https://github.com/dotnet/runtime |
| Microsoft.Extensions.Configuration.Json | 8.0.1 | MIT | https://github.com/dotnet/runtime |
| Microsoft.Extensions.Configuration.EnvironmentVariables | 8.0.1 | MIT | https://github.com/dotnet/runtime |
| Microsoft.Extensions.Logging.Console | 8.0.1 | MIT | https://github.com/dotnet/runtime |
| Microsoft.Extensions.Logging.EventLog | 8.0.1 | MIT | https://github.com/dotnet/runtime |
| System.Text.Json | 8.0.5 | MIT | https://github.com/dotnet/runtime |
| System.Net.Http.Json | 8.0.1 | MIT | https://github.com/dotnet/runtime |
| Polly | 8.4.0 | BSD-3-Clause | https://github.com/App-vNext/Polly |
| SharpCompress | 0.38.0 | MIT | https://github.com/adamhathcock/sharpcompress |
| YamlDotNet | 15.1.0 | MIT | https://github.com/aaubry/YamlDotNet |

### Java Dependencies (minecraft-bridge/paper/pom.xml)

| Package | Version | License | Repository |
|---------|---------|---------|------------|
| io.papermc.paper:paper-api | 1.20.4-R0.1-SNAPSHOT | MIT | https://github.com/PaperMC/Paper |
| pl.purpur:purpur-api | 1.20.4-R0.1-SNAPSHOT | MIT | https://github.com/PurpurMC/Purpur |
| com.google.code.gson:gson | 2.10.1 | Apache-2.0 | https://github.com/google/gson |

### System Dependencies

| Component | Version | License | Notes |
|-----------|---------|---------|-------|
| PHP | 8.2+ | PHP-3.01 | http://www.php.net/license/ |
| MariaDB | 10.11+ | GPL-2.0 | https://mariadb.org/about/legal/ |
| Nginx | 1.24+ | BSD-2-Clause | https://nginx.org/LICENSE |
| .NET Runtime | 8.0 | MIT | https://github.com/dotnet/runtime |
| Java (Eclipse Temurin) | 21 | GPL-2.0 with Classpath Exception | https://adoptium.net/license.html |
| Windows Server | 2019/2022 | Proprietary | Microsoft EULA |

### Fonts (Google Fonts - self-hosted recommended)

| Font | License | Source |
|------|---------|--------|
| Inter | SIL Open Font License 1.1 | https://fonts.google.com/specimen/Inter |
| JetBrains Mono | SIL Open Font License 1.1 | https://fonts.google.com/specimen/JetBrains+Mono |

### Icons (Inline SVG - original)

All SVG icons used in the UI are original inline SVG code, not from external icon sets.

---

## License Texts

### MIT License (Used by: Ratchet, ReactPHP, .NET packages, SharpCompress, YamlDotNet, Paper, Purpur)

```
MIT License

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```

### BSD-3-Clause (Used by: PHPUnit, Polly)

```
Redistribution and use in source and binary forms, with or without
modification, are permitted provided that the following conditions are met:

1. Redistributions of source code must retain the above copyright notice,
   this list of conditions and the following disclaimer.
2. Redistributions in binary form must reproduce the above copyright notice,
   this list of conditions and the following disclaimer in the documentation
   and/or other materials provided with the distribution.
3. Neither the name of the copyright holder nor the names of its contributors
   may be used to endorse or promote products derived from this software
   without specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE
LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
POSSIBILITY OF SUCH DAMAGE.
```

### Apache-2.0 (Used by: Gson)

```
Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
```

### GPL-2.0 (Used by: MariaDB, Java)

```
                    GNU GENERAL PUBLIC LICENSE
                       Version 2, June 1991

 Copyright (C) 1989, 1991 Free Software Foundation, Inc.
                       51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 Everyone is permitted to copy and distribute verbatim copies
 of this license document, but changing it is not allowed.
```

Full text: https://www.gnu.org/licenses/old-licenses/gpl-2.0.txt

### PHP-3.01 (Used by: PHP)

```
The PHP License, version 3.01
Copyright (c) 1999 - 2024 The PHP Group. All rights reserved.
```

Full text: https://www.php.net/license/3_01.txt

### BSD-2-Clause (Used by: Nginx)

```
Copyright (C) 2002-2024 Igor Sysoev
Copyright (C) 2011-2024 Nginx, Inc.
All rights reserved.

Redistribution and use in source and binary forms, with or without
modification, are permitted provided that the following conditions
are met:
1. Redistributions of source code must retain the above copyright
   notice, this list of conditions and the following disclaimer.
2. Redistributions in binary form must reproduce the above copyright
   notice, this list of conditions and the following disclaimer in the
   documentation and/or other materials provided with the distribution.

THIS SOFTWARE IS PROVIDED BY THE AUTHOR AND CONTRIBUTORS ``AS IS'' AND
ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
ARE DISCLAIMED.  IN NO EVENT SHALL THE AUTHOR OR CONTRIBUTORS BE LIABLE
FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS
OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)
HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY
OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF
SUCH DAMAGE.
```

### SIL Open Font License 1.1 (Used by: Inter, JetBrains Mono)

```
Copyright (c) 2016-2024, The Inter Project Authors
Copyright (c) 2014-2024, The JetBrains Project Authors

This Font Software is licensed under the SIL Open Font License, Version 1.1.
```

Full text: https://scripts.sil.org/OFL

---

## Attribution Requirements

When distributing or deploying Manu Hosting, the following must be preserved:

1. This LICENSES.md file must be included in the distribution
2. All copyright notices in source files must remain intact
3. Third-party license texts above must be accessible to end users
4. No endorsement by third-party projects is implied

---

## Contact

For license inquiries or commercial licensing:
- Project: Manu Hosting
- Repository: Private
- Contact: Via Owner Dashboard support system

---

*This file is automatically updated when dependencies change. Last updated: 2026-11-06*

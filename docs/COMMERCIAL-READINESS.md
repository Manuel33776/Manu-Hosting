# MANU HOSTING - COMMERCIAL READINESS CHECKLIST

## Legal & Compliance (Germany/EU)
- [ ] Impressum complete (Betreiber, ladungsfähige Anschrift, Kontakt, E-Mail)
- [ ] Datenschutzerklärung (GDPR Art. 13/14) - covers all data processing
- [ ] AGB (Terms of Service) - legally reviewed
- [ ] Widerrufsbelehrung (Consumer right of withdrawal)
- [ ] Cookie Policy / Consent Banner (ePrivacy)
- [ ] Auftragsverarbeitungsvertrag (AVV) template for customers
- [ ] Data Processing Register (Verarbeitungsverzeichnis Art. 30 GDPR)
- [ ] Data Retention Policy documented
- [ ] DDoS protection plan
- [ ] Incident Response Plan (72h breach notification)

## Technical Readiness
- [ ] Zero-downtime deployments working
- [ ] Automated backups tested (restore verified monthly)
- [ ] Monitoring alerting configured (uptime, resources, errors)
- [ ] Log aggregation & search (Graylog/ELK or similar)
- [ ] SSL/TLS A+ rating (SSL Labs test)
- [ ] Security headers implemented (CSP, HSTS, X-Frame-Options)
- [ ] Rate limiting on all endpoints
- [ ] SQL injection prevention (PDO only)
- [ ] XSS prevention (output encoding, CSP)
- [ ] CSRF protection on all forms
- [ ] Path traversal protection (file manager)
- [ ] Secrets management (no secrets in Git, .env.example provided)

## Multi-Tenant Isolation
- [ ] Separate Linux users per server (Debian)
- [ ] Windows Job Objects / Service Accounts per server (DL580)
- [ ] Filesystem ACLs preventing cross-access
- [ ] Database row-level security or application-level filtering
- [ ] Network isolation (VLAN/firewall per node)
- [ ] Resource quotas enforced (CPU, RAM, Disk, Network)
- [ ] Plugin/mod risk assessment documented
- [ ] No "root" or "Administrator" access for customers

## Operational Readiness
- [ ] Runbook for common incidents
- [ ] On-call rotation defined
- [ ] SLA definitions (uptime, response time, support hours)
- [ ] Backup SLA (RPO < 24h, RTO < 4h)
- [ ] Capacity planning (auto-scaling triggers for nodes)
- [ ] Update/patch management process
- [ ] Change management (approval, testing, rollback)
- [ ] Disaster recovery tested (quarterly)

## Business Readiness
- [ ] Pricing model finalized
- [ ] Payment integration (Stripe/PayPal/SEPA) - sandbox tested
- [ ] Invoice generation (automated, GoBD compliant)
- [ ] Customer onboarding flow (registration → verification → order → provision)
- [ ] Cancellation/termination process
- [ ] Support ticket SLA (response times per priority)
- [ ] Abuse handling process (spam, illegal content, DDoS)
- [ ] Refund policy documented

## Documentation for Handover
- [ ] Architecture documentation (this repo)
- [ ] Installation guides (Debian + Windows separate)
- [ ] API documentation (OpenAPI/Swagger)
- [ ] Database schema documentation
- [ ] Runbooks for all critical procedures
- [ ] Credentials inventory (stored in password manager)
- [ ] Vendor contacts (hosting, domains, SSL, payment)
- [ ] License inventory (all third-party components)

## Security Audit
- [ ] External penetration test (annual)
- [ ] Dependency vulnerability scan (Dependabot/Snyk)
- [ ] Code review process (PR required)
- [ ] Secret scanning (GitLeaks/TruffleHog in CI)
- [ ] Access review (quarterly: who has what access)

## Go-Live Checklist
- [ ] All placeholder data replaced with real data
- [ ] Maintenance mode OFF
- [ ] WIP banner OFF
- [ ] Server offline banner OFF
- [ ] DNS configured (A, AAAA, MX, SPF, DKIM, DMARC)
- [ ] SSL certificates valid (auto-renewal tested)
- [ ] Monitoring alerts active
- [ ] Backup jobs running
- [ ] Support email configured
- [ ] Legal pages reviewed by lawyer
- [ ] Owner approval obtained

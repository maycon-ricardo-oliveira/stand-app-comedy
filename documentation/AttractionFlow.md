
- [ ] Attraction
- [ ] Must ensure change status 
  - [ ] draft to published
  - [ ] published to finish
  - [ ] on change status draft to published update all sessions to

- [ ] Session
- [ ] Can't be possible create a session in a finish Attraction
- [ ] Can't be possible update a status to published, validating, active in a draft attraction
- [ ] Can be possible update session status to validating but attraction status need to be published
- [ ] Can be possible change a session status to active and finished but need check before status
- [ ] Can update tickets_validated only session status are validating
- [ ] Can update tickets_sold only session status are published

Tickets 
- [ ] Can create tickets only max limit on tickets session 
- [ ] Every create ticket need sum ticket_sold on session
- [ ] Can't sold more tickets than available on session definition
- [ ] Can't validate more tickets than sold on session definition
- [ ] Must ensure validate ticket on session status validating
- [ ] Must ensure validate ticket on session finish_at time

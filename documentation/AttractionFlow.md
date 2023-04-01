
- [x] Attraction
- [x] Must ensure change status 
  - [x] draft to published
  - [x] published to finish
  - [x] published to draft
  - [x] can't publish to publish

- [ ] Session
- [ ] Can't be possible create a session in a finish Attraction
- [ ] Can't be possible update a status to published, validating, active in a draft attraction
- [x] Can be possible update session status to validating but attraction status need to be published
- [ ] Can be possible change a session status to active and finished but need check before status
- [ ] Can update tickets_validated only session status are validating
- [ ] Can update tickets_sold only session status are published
- [ ] on change status draft to published update all sessions to

Tickets 
- [ ] Can create tickets only max limit on tickets session 
- [ ] Every create ticket need sum ticket_sold on session
- [ ] Can't sold more tickets than available on session definition
- [ ] Can't validate more tickets than sold on session definition
- [ ] Must ensure validate ticket on session status validating
- [ ] Must ensure validate ticket on session finish_at time


Places 
- [ ] Need a use case using mysql implementation



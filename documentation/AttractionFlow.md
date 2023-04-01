
- [x] Attraction
- [x] Must ensure change status 
  - [x] draft to published
  - [x] published to finish
  - [x] published to draft
  - [x] can't publish to publish

- [ ] Session

'draft', 'published', 'validating', 'in_progress', 'finish'

- [x] Can't be possible create a session in a finish Attraction
- [x] Can't be possible update a status to published, validating, in_progress in a draft attraction
- [x] Can be possible update session status to validating but attraction status need to be published
- [x] Can be possible change a session status to in_progress and finished but need check before status
- [ ] Can update tickets_validated only session status are validating
- [ ] Can update tickets_sold only session status are published
- [ ] on change status draft to published update all sessions to using a flag

Tickets
- [x] Can create tickets only max limit on tickets session 
- [x] Every create ticket need sum ticket_sold on session
- [x] Can't sold more tickets than available on session definition
- [ ] Can't validate more tickets than sold on session definition
- [ ] Must ensure validate ticket on session status validating
- [ ] Must ensure validate ticket on session finish_at time
- [ ] Checkin ticket can do it only sessions status VALIDATING and IN_PROGRESS


Places 
- [ ] Need a use case using mysql implementation

Infra 
- [ ] tests need a transaction insert in a database



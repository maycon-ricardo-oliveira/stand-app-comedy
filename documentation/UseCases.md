### Use Cases:
- [x] List Attractions by place
- [x] List Attractions by Location (Lat Long)
- [x] List Attractions by Comedian
- [x] Show data of a comedian profile
- [x] Login
- [x] Logout
- [x] Register
- [ ] Forgot password
- [ ] Recover password
- [x] Follow a comedian
- [x] UnFollow a comedian
- [x] Register an attraction
- [ ] List follow comedians
- [ ] Evaluate an Attraction with 5 stars
- [ ] Integrate of YouTube and get Most watched videos
- [ ] Integrate with GeoLocation Google Api
- [ ] Different roles to users
- [ ] Login with google using socialite lib
- [ ] can't register two sessions on a same time for same attraction

### Business Rules
- [ ] Only Attractions in a future date can be returned

### Dev Tools 
- [ ] Logger Adapter
- [ ] Unique Id Adapter

### Fix 
- [ ] check when used null parameters on ListAttractionsByLocation
- [ ] try catch on controllers to a beautiful exception
- [ ] password can't show on api

### Improvements
- [ ] Turn login logout tests better, not need database connection


### Architecture Base:
I Use Clean Architecture and Hexagonal Architecture with reference to do this. 
-Trying use best practices of SOLID principles.

- *S*RP: The Single Responsibility Principle.
- *O*CP: The Open Closed Principle.
- *L*SP: The Liskov Substitution Principle.
- *I*SP: The Interface Segregation Principle.
- *D*IP: The Dependency Inversion Principle.

- [Clean Architecture](http://cleancoder.com/);
- [Hexagonal](https://alistair.cockburn.us/hexagonal-architecture/);

# stand-app-comedy

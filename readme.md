# Course Submissions

the objective of this framework is to be able to handle course submissions

## Framework Setup

- clone project locally.
- ensure that docker is running on the system and has sufficient resources allocated.
- navigate to root project directory
- run command :
  
  ``` bash
    docker-compose up
  ```

## Use of Framework

- navigate to localhost:8100
- add values to input fields
- press submit button


## FAQ

- if there is a port conflict on a user's local system, change the port listed in the root docker-compose.yml

## TODO

- refactor database connection logic
- add JS modal library, for user notifications
- refactor Base Model, to be more flexible
- add composer support, to allow for external PHP libraries and to allow for testing
- reorganize code base, for futureproofing
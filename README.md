# Trivial Blog

## Intro

This is an implementation of a trivial weblog app just to try out ideas about different approaches to web application development. I'm looking for techniques that result in a the smallest amount of code possible, increasing maintainability and developer enjoyment through reduction of abstraction layers, while at the same time keeping the codebase intuitive and easy to understand.

## Setup

Use your own solution to compile `public/styles/main.scss` (sorry). Then...

    composer install # just for autoloading; we don't actually use any PHP libraries
    docker-compose up -d # schema.sql will be loaded automatically into 'db' container
    # now visit http://localhost:8080

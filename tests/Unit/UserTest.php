<?php

it('Should list all users')->get('api/users')->assertStatus(200);
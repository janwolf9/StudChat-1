import { Component, OnInit } from '@angular/core';


interface User {
    id: number;
    username: string;
    email: string;
    created: Date;

}

@Component({
  selector: 'app-profile',
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.scss']
})
export class ProfileComponent implements OnInit {
  user: User;

  constructor() { }

  ngOnInit() {
    this.user = {
      id: Number(localStorage.getItem('user.id')),
      username: localStorage.getItem('user.username'),
      email: localStorage.getItem('user.email'),
      created: new Date(localStorage.getItem('user.created')),
    };
  }

}

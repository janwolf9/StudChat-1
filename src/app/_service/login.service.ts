import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';


export class LoginOutput {
  id: number;
  username: string;
  email: string;
  created: Date;
}


@Injectable()
export class LoginService {
  constructor(
    private http: HttpClient
  ) {}

  login(username: string, password: string): Observable<any> {
    return this.http.post<any>('/api/login.php', { 'username': username, 'password': password });
  }
}

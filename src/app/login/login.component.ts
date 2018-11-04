import { Component, OnInit, ElementRef, OnDestroy, OnChanges, DoCheck } from '@angular/core';
import { FormBuilder, Validators } from '@angular/forms';
import { Router, ActivatedRoute, ParamMap } from '@angular/router';


import { MDCRipple } from '@material/ripple';
import { MDCTextField } from '@material/textfield';
import { MDCLinearProgress } from '@material/linear-progress';


import { LoginService } from '../_service/login.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit, OnDestroy {
  private _textFieldUsername: MDCTextField;
  private _textFieldPassword: MDCTextField;

  private _rippleCancel: MDCRipple;
  private _rippleLogin: MDCRipple;

  private loginForm = this.fb.group({
    username: [''],
    password: [''],
  });

  private submitting = false;
  private progressBar: MDCLinearProgress;
  private success = false;

  constructor(
    private fb: FormBuilder,
    private el: ElementRef,

    private route: ActivatedRoute,
    private router: Router,

    private loginService: LoginService
  ) { }

  progressBarReset() {
    this.progressBar.close();
  }
  progressBarLoading() {
    this.progressBar.open();
    this.progressBar.determinate = false;
  }
  progressBarDone(error: boolean) {
    this.progressBar.progress = 1;
    this.progressBar.determinate = true;
    this.success = false;
  }

  onSubmit() {
    // Lock
    if (this.submitting) { return; }
    this.submitting = true;

    // Animate bar
    this.progressBarLoading();


    // Login
    this.loginService.login(this.loginForm.value.username, this.loginForm.value.password).subscribe(
      (data) => {
        this.progressBarDone(true);
        this.submitting = false;

        localStorage.setItem('user.id', data.data.id);
        localStorage.setItem('user.username', data.data.username);
        localStorage.setItem('user.email', data.data.email);
        localStorage.setItem('user.created', data.data.created);

        this.router.navigate(['/profile']);
      },
      (error) => {
        console.log(error);
        this.progressBarDone(false);
        this.submitting = false;
      }
    );
  }

  ngOnInit() {
    this.progressBar = new MDCLinearProgress(this.el.nativeElement.querySelector('.progressbar'));
    this.progressBar.close();

    this._textFieldUsername = new MDCTextField(this.el.nativeElement.querySelector('.username'));
    this._textFieldPassword = new MDCTextField(this.el.nativeElement.querySelector('.password'));

    this._rippleCancel =  new MDCRipple(this.el.nativeElement.querySelector('.cancel'));
    this._rippleLogin =   new MDCRipple(this.el.nativeElement.querySelector('.login'));
  }

  ngOnDestroy() {

    // MDC
    this._textFieldUsername.destroy();
    this._textFieldPassword.destroy();
    this._rippleCancel.destroy();
    this._rippleLogin.destroy();

    this.progressBar.destroy();
  }
}

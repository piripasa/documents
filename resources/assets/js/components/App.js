import React from "react";
import {render} from "react-dom";
import {BrowserRouter, Route, Switch, withRouter} from "react-router-dom";
import Home from "./Home";
import Login from "./Login";
import Register from "./Register";
import {BASE_URL} from "../config";

import axios from "axios";
import $ from "jquery";

class App extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            isLoggedIn: false,
            user: {}
        };
        this._loginUser = this._loginUser.bind(this);
        this._registerUser = this._registerUser.bind(this);
        this._logoutUser = this._logoutUser.bind(this);
    }

    _loginUser(email, password) {
        $("#login-form button")
            .attr("disabled", "disabled")
            .html(
                '<i class="fa fa-spinner fa-spin fa-1x fa-fw"></i><span class="sr-only">Loading...</span>'
            );
        var formData = new FormData();
        formData.append("email", email);
        formData.append("password", password);

        axios
            .post(`${BASE_URL}auth/tokens`, formData)
            .then(response => {
                console.log(response);
                return response;
            })
            .then(json => {
                if (json.data) {
                    alert("Login Successful!");
                    const {user, token} = json.data;

                    let userData = {
                        name: user.name,
                        id: user.id,
                        email: user.email,
                        auth_token: token,
                        timestamp: new Date().toString()
                    };
                    let appState = {
                        isLoggedIn: true,
                        user: userData
                    };
                    console.log(appState);
                    // save app state with user date in local storage
                    localStorage["appState"] = JSON.stringify(appState);
                    this.setState({
                        isLoggedIn: appState.isLoggedIn,
                        user: appState.user
                    });
                    // redirect home
                    this.props.history.push("/home");
                } else alert("Login Failed!");

                $("#login-form button")
                    .removeAttr("disabled")
                    .html("Login");
            });
        // .catch(error => {
        //     alert(`An Error Occured! ${error}`);
        //     $("#login-form button")
        //         .removeAttr("disabled")
        //         .html("Login");
        // });
    };

    _registerUser(name, email, password, confirm_password) {
        $("#email-login-btn")
            .attr("disabled", "disabled")
            .html(
                '<i class="fa fa-spinner fa-spin fa-1x fa-fw"></i><span class="sr-only">Loading...</span>'
            );

        var formData = new FormData();
        formData.append("password", password);
        formData.append("confirm_password", confirm_password);
        formData.append("email", email);
        formData.append("name", name);

        axios
            .post(`${BASE_URL}users`, formData)
            .then(response => {
                console.log(response);
                return response;
            })
            .then(json => {
                if (json.data.success) {
                    alert(`Registration Successful!`);
                    // redirect login
                    this.props.history.push("/home/login");
                } else {
                    alert(`Registration Failed!`);
                    $("#email-login-btn")
                        .removeAttr("disabled")
                        .html("Register");
                }
            })
            .catch(error => {
                alert("An Error Occured!" + error);
                console.log(`${formData} ${error}`);
                $("#email-login-btn")
                    .removeAttr("disabled")
                    .html("Register");
            });
    };

    _logoutUser() {
        let appState = {
            isLoggedIn: false,
            user: {}
        };
        // save app state with user date in local storage
        localStorage["appState"] = JSON.stringify(appState);
        this.setState(appState);
    };

    componentDidMount() {
        let state = localStorage["appState"];
        if (state) {
            let AppState = JSON.parse(state);
            console.log(AppState);
            this.setState({isLoggedIn: AppState.isLoggedIn, user: AppState.user});
        }
    }

    render() {
        console.log(this.state.isLoggedIn);
        console.log("path name: " + this.props.location.pathname);
        if (
            !this.state.isLoggedIn &&
            this.props.location.pathname !== "/home/login" &&
            this.props.location.pathname !== "/home/register"
        ) {
            console.log(
                "you are not loggedin and are not visiting login or register, so go to login page"
            );
            this.props.history.push("/home/login");
        }
        if (
            this.state.isLoggedIn &&
            (this.props.location.pathname === "/home/login" ||
                this.props.location.pathname === "/home/register")
        ) {
            console.log(
                "you are either going to login or register but youre logged in"
            );

            this.props.history.push("/home");
        }
        return (
            <Switch data="data">
                <div id="main">
                    <Route
                        exact
                        path="/home"
                        render={props => (
                            <Home
                                {...props}
                                logoutUser={this._logoutUser}
                                user={this.state.user}
                            />
                        )}
                    />

                    <Route
                        path="/home/login"
                        render={props => <Login {...props} loginUser={this._loginUser}/>}
                    />

                    <Route
                        path="/home/register"
                        render={props => (
                            <Register {...props} registerUser={this._registerUser}/>
                        )}
                    />
                </div>
            </Switch>
        );
    }
}

const AppContainer = withRouter(props => <App {...props} />);
// console.log(store.getState())
render(
    <BrowserRouter>
        <AppContainer/>
    </BrowserRouter>,

    document.getElementById("app")
);
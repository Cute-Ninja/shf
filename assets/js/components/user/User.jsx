import React from "react";
import ApiClient from "../common/ApiClient";

class User extends React.Component {

    constructor() {
        super();
        this.state = {
            isLoaded:false,
            user: null
        };
    }

    componentDidMount() {
        ApiClient.getOne("/api/users/me")
            .then((result) => {
                this.setState({
                    isLoaded: true,
                    user: result
                });
            });
    }

    render() {
        const { isLoaded, user } = this.state;
        if (false === isLoaded) {
            return <div>Loading...</div>
        }

        return (
            <div>
                <h3>{ user.username }</h3>
                <p>
                    { user.email }
                </p>
            </div>
        );
    }
}

export default User;

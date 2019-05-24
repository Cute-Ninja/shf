import React from "react";

class User extends React.Component {

    constructor() {
        super();
        this.state = {
            user: { 'username': 'Ghriim'}
        }
    }

    render() {
        const { user } = this.state;
        return (
            <div>
                <h3>{ user.username }</h3>
            </div>
        );
    }
}

export default User;

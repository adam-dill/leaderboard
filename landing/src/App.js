import React from 'react';
import './App.css';
import { BrowserRouter as Router, Switch, Route, Link } from 'react-router-dom';
import HomeScreen from './screens/home';
import AboutScreen from './screens/about';
import ContactScreen from './screens/contact';

function App() {
  return (
    <Router>
      <div className="App">
        <header className="App-header">
          <h1><Link to="/">Leaderboards</Link></h1>
          <nav>
            <ul>
              <li><Link to="/">Games</Link></li>
              <li><Link to="/about">About</Link></li>
              <li><Link to="/contact">Contact</Link></li>
            </ul>
          </nav>
        </header>
        <Switch>
          <Route path="/about">
            <AboutScreen />
          </Route>
          <Route path="/contact">
            <ContactScreen />
          </Route>
          <Route path="/">
            <HomeScreen />
          </Route>
        </Switch>
      </div>
    </Router>
  );
}

export default App;

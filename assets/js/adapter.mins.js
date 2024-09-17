!(function (e) {
  if ("object" == typeof exports && "undefined" != typeof module)
    module.exports = e();
  else if ("function" == typeof define && define.amd) define([], e);
  else {
    var t;
    (t =
      "undefined" != typeof window
        ? window
        : "undefined" != typeof global
        ? global
        : "undefined" != typeof self
        ? self
        : this),
      (t.adapter = e());
  }
})(function () {
  return (function e(t, r, n) {
    function i(o, s) {
      if (!r[o]) {
        if (!t[o]) {
          var c = "function" == typeof require && require;
          if (!s && c) return c(o, !0);
          if (a) return a(o, !0);
          var d = new Error("Cannot find module '" + o + "'");
          throw ((d.code = "MODULE_NOT_FOUND"), d);
        }
        var p = (r[o] = { exports: {} });
        t[o][0].call(
          p.exports,
          function (e) {
            var r = t[o][1][e];
            return i(r || e);
          },
          p,
          p.exports,
          e,
          t,
          r,
          n
        );
      }
      return r[o].exports;
    }
    for (
      var a = "function" == typeof require && require, o = 0;
      o < n.length;
      o++
    )
      i(n[o]);
    return i;
  })(
    {
      1: [
        function (e, t, r) {
          "use strict";
          var n = {};
          (n.generateIdentifier = function () {
            return Math.random().toString(36).substr(2, 10);
          }),
            (n.localCName = n.generateIdentifier()),
            (n.splitLines = function (e) {
              return e
                .trim()
                .split("\n")
                .map(function (e) {
                  return e.trim();
                });
            }),
            (n.splitSections = function (e) {
              return e.split("\nm=").map(function (e, t) {
                return (t > 0 ? "m=" + e : e).trim() + "\r\n";
              });
            }),
            (n.matchPrefix = function (e, t) {
              return n.splitLines(e).filter(function (e) {
                return 0 === e.indexOf(t);
              });
            }),
            (n.parseCandidate = function (e) {
              var t;
              t =
                0 === e.indexOf("a=candidate:")
                  ? e.substring(12).split(" ")
                  : e.substring(10).split(" ");
              for (
                var r = {
                    foundation: t[0],
                    component: t[1],
                    protocol: t[2].toLowerCase(),
                    priority: parseInt(t[3], 10),
                    ip: t[4],
                    port: parseInt(t[5], 10),
                    type: t[7],
                  },
                  n = 8;
                n < t.length;
                n += 2
              )
                switch (t[n]) {
                  case "raddr":
                    r.relatedAddress = t[n + 1];
                    break;
                  case "rport":
                    r.relatedPort = parseInt(t[n + 1], 10);
                    break;
                  case "tcptype":
                    r.tcpType = t[n + 1];
                }
              return r;
            }),
            (n.writeCandidate = function (e) {
              var t = [];
              t.push(e.foundation),
                t.push(e.component),
                t.push(e.protocol.toUpperCase()),
                t.push(e.priority),
                t.push(e.ip),
                t.push(e.port);
              var r = e.type;
              return (
                t.push("typ"),
                t.push(r),
                "host" !== r &&
                  e.relatedAddress &&
                  e.relatedPort &&
                  (t.push("raddr"),
                  t.push(e.relatedAddress),
                  t.push("rport"),
                  t.push(e.relatedPort)),
                e.tcpType &&
                  "tcp" === e.protocol.toLowerCase() &&
                  (t.push("tcptype"), t.push(e.tcpType)),
                "candidate:" + t.join(" ")
              );
            }),
            (n.parseRtpMap = function (e) {
              var t = e.substr(9).split(" "),
                r = { payloadType: parseInt(t.shift(), 10) };
              return (
                (t = t[0].split("/")),
                (r.name = t[0]),
                (r.clockRate = parseInt(t[1], 10)),
                (r.numChannels = 3 === t.length ? parseInt(t[2], 10) : 1),
                r
              );
            }),
            (n.writeRtpMap = function (e) {
              var t = e.payloadType;
              return (
                void 0 !== e.preferredPayloadType &&
                  (t = e.preferredPayloadType),
                "a=rtpmap:" +
                  t +
                  " " +
                  e.name +
                  "/" +
                  e.clockRate +
                  (1 !== e.numChannels ? "/" + e.numChannels : "") +
                  "\r\n"
              );
            }),
            (n.parseExtmap = function (e) {
              var t = e.substr(9).split(" ");
              return { id: parseInt(t[0], 10), uri: t[1] };
            }),
            (n.writeExtmap = function (e) {
              return (
                "a=extmap:" + (e.id || e.preferredId) + " " + e.uri + "\r\n"
              );
            }),
            (n.parseFmtp = function (e) {
              for (
                var t,
                  r = {},
                  n = e.substr(e.indexOf(" ") + 1).split(";"),
                  i = 0;
                i < n.length;
                i++
              )
                (t = n[i].trim().split("=")), (r[t[0].trim()] = t[1]);
              return r;
            }),
            (n.writeFmtp = function (e) {
              var t = "",
                r = e.payloadType;
              if (
                (void 0 !== e.preferredPayloadType &&
                  (r = e.preferredPayloadType),
                e.parameters && Object.keys(e.parameters).length)
              ) {
                var n = [];
                Object.keys(e.parameters).forEach(function (t) {
                  n.push(t + "=" + e.parameters[t]);
                }),
                  (t += "a=fmtp:" + r + " " + n.join(";") + "\r\n");
              }
              return t;
            }),
            (n.parseRtcpFb = function (e) {
              var t = e.substr(e.indexOf(" ") + 1).split(" ");
              return { type: t.shift(), parameter: t.join(" ") };
            }),
            (n.writeRtcpFb = function (e) {
              var t = "",
                r = e.payloadType;
              return (
                void 0 !== e.preferredPayloadType &&
                  (r = e.preferredPayloadType),
                e.rtcpFeedback &&
                  e.rtcpFeedback.length &&
                  e.rtcpFeedback.forEach(function (e) {
                    t +=
                      "a=rtcp-fb:" +
                      r +
                      " " +
                      e.type +
                      (e.parameter && e.parameter.length
                        ? " " + e.parameter
                        : "") +
                      "\r\n";
                  }),
                t
              );
            }),
            (n.parseSsrcMedia = function (e) {
              var t = e.indexOf(" "),
                r = { ssrc: parseInt(e.substr(7, t - 7), 10) },
                n = e.indexOf(":", t);
              return (
                n > -1
                  ? ((r.attribute = e.substr(t + 1, n - t - 1)),
                    (r.value = e.substr(n + 1)))
                  : (r.attribute = e.substr(t + 1)),
                r
              );
            }),
            (n.getMid = function (e) {
              var t = n.matchPrefix(e, "a=mid:")[0];
              if (t) return t.substr(6);
            }),
            (n.getDtlsParameters = function (e, t) {
              var r = n.splitLines(e);
              r = r.concat(n.splitLines(t));
              var i = r
                .filter(function (e) {
                  return 0 === e.indexOf("a=fingerprint:");
                })[0]
                .substr(14);
              return {
                role: "auto",
                fingerprints: [
                  {
                    algorithm: i.split(" ")[0].toLowerCase(),
                    value: i.split(" ")[1],
                  },
                ],
              };
            }),
            (n.writeDtlsParameters = function (e, t) {
              var r = "a=setup:" + t + "\r\n";
              return (
                e.fingerprints.forEach(function (e) {
                  r += "a=fingerprint:" + e.algorithm + " " + e.value + "\r\n";
                }),
                r
              );
            }),
            (n.getIceParameters = function (e, t) {
              var r = n.splitLines(e);
              return (
                (r = r.concat(n.splitLines(t))),
                {
                  usernameFragment: r
                    .filter(function (e) {
                      return 0 === e.indexOf("a=ice-ufrag:");
                    })[0]
                    .substr(12),
                  password: r
                    .filter(function (e) {
                      return 0 === e.indexOf("a=ice-pwd:");
                    })[0]
                    .substr(10),
                }
              );
            }),
            (n.writeIceParameters = function (e) {
              return (
                "a=ice-ufrag:" +
                e.usernameFragment +
                "\r\na=ice-pwd:" +
                e.password +
                "\r\n"
              );
            }),
            (n.parseRtpParameters = function (e) {
              for (
                var t = {
                    codecs: [],
                    headerExtensions: [],
                    fecMechanisms: [],
                    rtcp: [],
                  },
                  r = n.splitLines(e),
                  i = r[0].split(" "),
                  a = 3;
                a < i.length;
                a++
              ) {
                var o = i[a],
                  s = n.matchPrefix(e, "a=rtpmap:" + o + " ")[0];
                if (s) {
                  var c = n.parseRtpMap(s),
                    d = n.matchPrefix(e, "a=fmtp:" + o + " ");
                  switch (
                    ((c.parameters = d.length ? n.parseFmtp(d[0]) : {}),
                    (c.rtcpFeedback = n
                      .matchPrefix(e, "a=rtcp-fb:" + o + " ")
                      .map(n.parseRtcpFb)),
                    t.codecs.push(c),
                    c.name.toUpperCase())
                  ) {
                    case "RED":
                    case "ULPFEC":
                      t.fecMechanisms.push(c.name.toUpperCase());
                  }
                }
              }
              return (
                n.matchPrefix(e, "a=extmap:").forEach(function (e) {
                  t.headerExtensions.push(n.parseExtmap(e));
                }),
                t
              );
            }),
            (n.writeRtpDescription = function (e, t) {
              var r = "";
              (r += "m=" + e + " "),
                (r += t.codecs.length > 0 ? "9" : "0"),
                (r += " UDP/TLS/RTP/SAVPF "),
                (r +=
                  t.codecs
                    .map(function (e) {
                      return void 0 !== e.preferredPayloadType
                        ? e.preferredPayloadType
                        : e.payloadType;
                    })
                    .join(" ") + "\r\n"),
                (r += "c=IN IP4 0.0.0.0\r\n"),
                (r += "a=rtcp:9 IN IP4 0.0.0.0\r\n"),
                t.codecs.forEach(function (e) {
                  (r += n.writeRtpMap(e)),
                    (r += n.writeFmtp(e)),
                    (r += n.writeRtcpFb(e));
                });
              var i = 0;
              return (
                t.codecs.forEach(function (e) {
                  e.maxptime > i && (i = e.maxptime);
                }),
                i > 0 && (r += "a=maxptime:" + i + "\r\n"),
                (r += "a=rtcp-mux\r\n"),
                t.headerExtensions.forEach(function (e) {
                  r += n.writeExtmap(e);
                }),
                r
              );
            }),
            (n.parseRtpEncodingParameters = function (e) {
              var t,
                r = [],
                i = n.parseRtpParameters(e),
                a = -1 !== i.fecMechanisms.indexOf("RED"),
                o = -1 !== i.fecMechanisms.indexOf("ULPFEC"),
                s = n
                  .matchPrefix(e, "a=ssrc:")
                  .map(function (e) {
                    return n.parseSsrcMedia(e);
                  })
                  .filter(function (e) {
                    return "cname" === e.attribute;
                  }),
                c = s.length > 0 && s[0].ssrc,
                d = n.matchPrefix(e, "a=ssrc-group:FID").map(function (e) {
                  var t = e.split(" ");
                  return (
                    t.shift(),
                    t.map(function (e) {
                      return parseInt(e, 10);
                    })
                  );
                });
              d.length > 0 && d[0].length > 1 && d[0][0] === c && (t = d[0][1]),
                i.codecs.forEach(function (e) {
                  if ("RTX" === e.name.toUpperCase() && e.parameters.apt) {
                    var n = {
                      ssrc: c,
                      codecPayloadType: parseInt(e.parameters.apt, 10),
                      rtx: { ssrc: t },
                    };
                    r.push(n),
                      a &&
                        ((n = JSON.parse(JSON.stringify(n))),
                        (n.fec = {
                          ssrc: t,
                          mechanism: o ? "red+ulpfec" : "red",
                        }),
                        r.push(n));
                  }
                }),
                0 === r.length && c && r.push({ ssrc: c });
              var p = n.matchPrefix(e, "b=");
              return (
                p.length &&
                  (0 === p[0].indexOf("b=TIAS:")
                    ? (p = parseInt(p[0].substr(7), 10))
                    : 0 === p[0].indexOf("b=AS:") &&
                      (p = parseInt(p[0].substr(5), 10)),
                  r.forEach(function (e) {
                    e.maxBitrate = p;
                  })),
                r
              );
            }),
            (n.parseRtcpParameters = function (e) {
              var t = {},
                r = n
                  .matchPrefix(e, "a=ssrc:")
                  .map(function (e) {
                    return n.parseSsrcMedia(e);
                  })
                  .filter(function (e) {
                    return "cname" === e.attribute;
                  })[0];
              r && ((t.cname = r.value), (t.ssrc = r.ssrc));
              var i = n.matchPrefix(e, "a=rtcp-rsize");
              (t.reducedSize = i.length > 0), (t.compound = 0 === i.length);
              var a = n.matchPrefix(e, "a=rtcp-mux");
              return (t.mux = a.length > 0), t;
            }),
            (n.parseMsid = function (e) {
              var t,
                r = n.matchPrefix(e, "a=msid:");
              if (1 === r.length)
                return (
                  (t = r[0].substr(7).split(" ")), { stream: t[0], track: t[1] }
                );
              var i = n
                .matchPrefix(e, "a=ssrc:")
                .map(function (e) {
                  return n.parseSsrcMedia(e);
                })
                .filter(function (e) {
                  return "msid" === e.attribute;
                });
              return i.length > 0
                ? ((t = i[0].value.split(" ")), { stream: t[0], track: t[1] })
                : void 0;
            }),
            (n.writeSessionBoilerplate = function () {
              return "v=0\r\no=thisisadapterortc 8169639915646943137 2 IN IP4 127.0.0.1\r\ns=-\r\nt=0 0\r\n";
            }),
            (n.writeMediaSection = function (e, t, r, i) {
              var a = n.writeRtpDescription(e.kind, t);
              if (
                ((a += n.writeIceParameters(
                  e.iceGatherer.getLocalParameters()
                )),
                (a += n.writeDtlsParameters(
                  e.dtlsTransport.getLocalParameters(),
                  "offer" === r ? "actpass" : "active"
                )),
                (a += "a=mid:" + e.mid + "\r\n"),
                e.rtpSender && e.rtpReceiver
                  ? (a += "a=sendrecv\r\n")
                  : e.rtpSender
                  ? (a += "a=sendonly\r\n")
                  : e.rtpReceiver
                  ? (a += "a=recvonly\r\n")
                  : (a += "a=inactive\r\n"),
                e.rtpSender)
              ) {
                var o = "msid:" + i.id + " " + e.rtpSender.track.id + "\r\n";
                (a += "a=" + o),
                  (a += "a=ssrc:" + e.sendEncodingParameters[0].ssrc + " " + o),
                  e.sendEncodingParameters[0].rtx &&
                    ((a +=
                      "a=ssrc:" +
                      e.sendEncodingParameters[0].rtx.ssrc +
                      " " +
                      o),
                    (a +=
                      "a=ssrc-group:FID " +
                      e.sendEncodingParameters[0].ssrc +
                      " " +
                      e.sendEncodingParameters[0].rtx.ssrc +
                      "\r\n"));
              }
              return (
                (a +=
                  "a=ssrc:" +
                  e.sendEncodingParameters[0].ssrc +
                  " cname:" +
                  n.localCName +
                  "\r\n"),
                e.rtpSender &&
                  e.sendEncodingParameters[0].rtx &&
                  (a +=
                    "a=ssrc:" +
                    e.sendEncodingParameters[0].rtx.ssrc +
                    " cname:" +
                    n.localCName +
                    "\r\n"),
                a
              );
            }),
            (n.getDirection = function (e, t) {
              for (var r = n.splitLines(e), i = 0; i < r.length; i++)
                switch (r[i]) {
                  case "a=sendrecv":
                  case "a=sendonly":
                  case "a=recvonly":
                  case "a=inactive":
                    return r[i].substr(2);
                }
              return t ? n.getDirection(t) : "sendrecv";
            }),
            (n.getKind = function (e) {
              return n.splitLines(e)[0].split(" ")[0].substr(2);
            }),
            (n.isRejected = function (e) {
              return "0" === e.split(" ", 2)[1];
            }),
            (t.exports = n);
        },
        {},
      ],
      2: [
        function (e, t, r) {
          "use strict";
          !(function () {
            var r = e("./utils"),
              n = r.log,
              i = r.browserDetails;
            (t.exports.browserDetails = i),
              (t.exports.extractVersion = r.extractVersion),
              (t.exports.disableLog = r.disableLog);
            var a = e("./chrome/chrome_shim") || null,
              o = e("./edge/edge_shim") || null,
              s = e("./firefox/firefox_shim") || null,
              c = e("./safari/safari_shim") || null;
            switch (i.browser) {
              case "chrome":
                if (!a || !a.shimPeerConnection)
                  return void n(
                    "Chrome shim is not included in this adapter release."
                  );
                n("adapter.js shimming chrome."),
                  (t.exports.browserShim = a),
                  a.shimGetUserMedia(),
                  a.shimMediaStream(),
                  r.shimCreateObjectURL(),
                  a.shimSourceObject(),
                  a.shimPeerConnection(),
                  a.shimOnTrack(),
                  a.shimGetSendersWithDtmf();
                break;
              case "firefox":
                if (!s || !s.shimPeerConnection)
                  return void n(
                    "Firefox shim is not included in this adapter release."
                  );
                n("adapter.js shimming firefox."),
                  (t.exports.browserShim = s),
                  s.shimGetUserMedia(),
                  r.shimCreateObjectURL(),
                  s.shimSourceObject(),
                  s.shimPeerConnection(),
                  s.shimOnTrack();
                break;
              case "edge":
                if (!o || !o.shimPeerConnection)
                  return void n(
                    "MS edge shim is not included in this adapter release."
                  );
                n("adapter.js shimming edge."),
                  (t.exports.browserShim = o),
                  o.shimGetUserMedia(),
                  r.shimCreateObjectURL(),
                  o.shimPeerConnection(),
                  o.shimReplaceTrack();
                break;
              case "safari":
                if (!c)
                  return void n(
                    "Safari shim is not included in this adapter release."
                  );
                n("adapter.js shimming safari."),
                  (t.exports.browserShim = c),
                  c.shimOnAddStream(),
                  c.shimGetUserMedia();
                break;
              default:
                n("Unsupported browser!");
            }
          })();
        },
        {
          "./chrome/chrome_shim": 3,
          "./edge/edge_shim": 5,
          "./firefox/firefox_shim": 8,
          "./safari/safari_shim": 10,
          "./utils": 11,
        },
      ],
      3: [
        function (e, t, r) {
          "use strict";
          var n = e("../utils.js").log,
            i = e("../utils.js").browserDetails,
            a = {
              shimMediaStream: function () {
                window.MediaStream =
                  window.MediaStream || window.webkitMediaStream;
              },
              shimOnTrack: function () {
                "object" != typeof window ||
                  !window.RTCPeerConnection ||
                  "ontrack" in window.RTCPeerConnection.prototype ||
                  Object.defineProperty(
                    window.RTCPeerConnection.prototype,
                    "ontrack",
                    {
                      get: function () {
                        return this._ontrack;
                      },
                      set: function (e) {
                        var t = this;
                        this._ontrack &&
                          (this.removeEventListener("track", this._ontrack),
                          this.removeEventListener(
                            "addstream",
                            this._ontrackpoly
                          )),
                          this.addEventListener("track", (this._ontrack = e)),
                          this.addEventListener(
                            "addstream",
                            (this._ontrackpoly = function (e) {
                              e.stream.addEventListener(
                                "addtrack",
                                function (r) {
                                  var n = new Event("track");
                                  (n.track = r.track),
                                    (n.receiver = { track: r.track }),
                                    (n.streams = [e.stream]),
                                    t.dispatchEvent(n);
                                }
                              ),
                                e.stream.getTracks().forEach(
                                  function (t) {
                                    var r = new Event("track");
                                    (r.track = t),
                                      (r.receiver = { track: t }),
                                      (r.streams = [e.stream]),
                                      this.dispatchEvent(r);
                                  }.bind(this)
                                );
                            }.bind(this))
                          );
                      },
                    }
                  );
              },
              shimGetSendersWithDtmf: function () {
                if (
                  "object" == typeof window &&
                  window.RTCPeerConnection &&
                  !("getSenders" in RTCPeerConnection.prototype) &&
                  "createDTMFSender" in RTCPeerConnection.prototype
                ) {
                  RTCPeerConnection.prototype.getSenders = function () {
                    return this._senders;
                  };
                  var e = RTCPeerConnection.prototype.addStream,
                    t = RTCPeerConnection.prototype.removeStream;
                  (RTCPeerConnection.prototype.addStream = function (t) {
                    var r = this;
                    (r._senders = r._senders || []),
                      e.apply(r, [t]),
                      t.getTracks().forEach(function (e) {
                        r._senders.push({
                          track: e,
                          get dtmf() {
                            return (
                              void 0 === this._dtmf &&
                                ("audio" === e.kind
                                  ? (this._dtmf = r.createDTMFSender(e))
                                  : (this._dtmf = null)),
                              this._dtmf
                            );
                          },
                        });
                      });
                  }),
                    (RTCPeerConnection.prototype.removeStream = function (e) {
                      var r = this;
                      (r._senders = r._senders || []),
                        t.apply(r, [e]),
                        e.getTracks().forEach(function (e) {
                          var t = r._senders.find(function (t) {
                            return t.track === e;
                          });
                          t && r._senders.splice(r._senders.indexOf(t), 1);
                        });
                    });
                }
              },
              shimSourceObject: function () {
                "object" == typeof window &&
                  (!window.HTMLMediaElement ||
                    "srcObject" in window.HTMLMediaElement.prototype ||
                    Object.defineProperty(
                      window.HTMLMediaElement.prototype,
                      "srcObject",
                      {
                        get: function () {
                          return this._srcObject;
                        },
                        set: function (e) {
                          var t = this;
                          if (
                            ((this._srcObject = e),
                            this.src && URL.revokeObjectURL(this.src),
                            !e)
                          )
                            return void (this.src = "");
                          (this.src = URL.createObjectURL(e)),
                            e.addEventListener("addtrack", function () {
                              t.src && URL.revokeObjectURL(t.src),
                                (t.src = URL.createObjectURL(e));
                            }),
                            e.addEventListener("removetrack", function () {
                              t.src && URL.revokeObjectURL(t.src),
                                (t.src = URL.createObjectURL(e));
                            });
                        },
                      }
                    ));
              },
              shimPeerConnection: function () {
                if (window.RTCPeerConnection) {
                  var e = RTCPeerConnection;
                  (window.RTCPeerConnection = function (t, r) {
                    if (t && t.iceServers) {
                      for (var n = [], i = 0; i < t.iceServers.length; i++) {
                        var a = t.iceServers[i];
                        !a.hasOwnProperty("urls") && a.hasOwnProperty("url")
                          ? (console.warn(
                              "RTCIceServer.url is deprecated! Use urls instead."
                            ),
                            (a = JSON.parse(JSON.stringify(a))),
                            (a.urls = a.url),
                            n.push(a))
                          : n.push(t.iceServers[i]);
                      }
                      t.iceServers = n;
                    }
                    return new e(t, r);
                  }),
                    (window.RTCPeerConnection.prototype = e.prototype),
                    Object.defineProperty(
                      window.RTCPeerConnection,
                      "generateCertificate",
                      {
                        get: function () {
                          return e.generateCertificate;
                        },
                      }
                    );
                } else
                  (window.RTCPeerConnection = function (e, t) {
                    return (
                      n("PeerConnection"),
                      e &&
                        e.iceTransportPolicy &&
                        (e.iceTransports = e.iceTransportPolicy),
                      new webkitRTCPeerConnection(e, t)
                    );
                  }),
                    (window.RTCPeerConnection.prototype =
                      webkitRTCPeerConnection.prototype),
                    webkitRTCPeerConnection.generateCertificate &&
                      Object.defineProperty(
                        window.RTCPeerConnection,
                        "generateCertificate",
                        {
                          get: function () {
                            return webkitRTCPeerConnection.generateCertificate;
                          },
                        }
                      );
                var t = RTCPeerConnection.prototype.getStats;
                (RTCPeerConnection.prototype.getStats = function (e, r, n) {
                  var i = this,
                    a = arguments;
                  if (arguments.length > 0 && "function" == typeof e)
                    return t.apply(this, arguments);
                  if (
                    0 === t.length &&
                    (0 === arguments.length ||
                      "function" != typeof arguments[0])
                  )
                    return t.apply(this, []);
                  var o = function (e) {
                      var t = {};
                      return (
                        e.result().forEach(function (e) {
                          var r = {
                            id: e.id,
                            timestamp: e.timestamp,
                            type:
                              {
                                localcandidate: "local-candidate",
                                remotecandidate: "remote-candidate",
                              }[e.type] || e.type,
                          };
                          e.names().forEach(function (t) {
                            r[t] = e.stat(t);
                          }),
                            (t[r.id] = r);
                        }),
                        t
                      );
                    },
                    s = function (e) {
                      return new Map(
                        Object.keys(e).map(function (t) {
                          return [t, e[t]];
                        })
                      );
                    };
                  if (arguments.length >= 2) {
                    var c = function (e) {
                      a[1](s(o(e)));
                    };
                    return t.apply(this, [c, arguments[0]]);
                  }
                  return new Promise(function (e, r) {
                    t.apply(i, [
                      function (t) {
                        e(s(o(t)));
                      },
                      r,
                    ]);
                  }).then(r, n);
                }),
                  i.version < 51 &&
                    [
                      "setLocalDescription",
                      "setRemoteDescription",
                      "addIceCandidate",
                    ].forEach(function (e) {
                      var t = RTCPeerConnection.prototype[e];
                      RTCPeerConnection.prototype[e] = function () {
                        var e = arguments,
                          r = this,
                          n = new Promise(function (n, i) {
                            t.apply(r, [e[0], n, i]);
                          });
                        return e.length < 2
                          ? n
                          : n.then(
                              function () {
                                e[1].apply(null, []);
                              },
                              function (t) {
                                e.length >= 3 && e[2].apply(null, [t]);
                              }
                            );
                      };
                    }),
                  i.version < 52 &&
                    ["createOffer", "createAnswer"].forEach(function (e) {
                      var t = RTCPeerConnection.prototype[e];
                      RTCPeerConnection.prototype[e] = function () {
                        var e = this;
                        if (
                          arguments.length < 1 ||
                          (1 === arguments.length &&
                            "object" == typeof arguments[0])
                        ) {
                          var r =
                            1 === arguments.length ? arguments[0] : void 0;
                          return new Promise(function (n, i) {
                            t.apply(e, [n, i, r]);
                          });
                        }
                        return t.apply(this, arguments);
                      };
                    }),
                  [
                    "setLocalDescription",
                    "setRemoteDescription",
                    "addIceCandidate",
                  ].forEach(function (e) {
                    var t = RTCPeerConnection.prototype[e];
                    RTCPeerConnection.prototype[e] = function () {
                      return (
                        (arguments[0] = new (
                          "addIceCandidate" === e
                            ? RTCIceCandidate
                            : RTCSessionDescription
                        )(arguments[0])),
                        t.apply(this, arguments)
                      );
                    };
                  });
                var r = RTCPeerConnection.prototype.addIceCandidate;
                RTCPeerConnection.prototype.addIceCandidate = function () {
                  return arguments[0]
                    ? r.apply(this, arguments)
                    : (arguments[1] && arguments[1].apply(null),
                      Promise.resolve());
                };
              },
            };
          t.exports = {
            shimMediaStream: a.shimMediaStream,
            shimOnTrack: a.shimOnTrack,
            shimGetSendersWithDtmf: a.shimGetSendersWithDtmf,
            shimSourceObject: a.shimSourceObject,
            shimPeerConnection: a.shimPeerConnection,
            shimGetUserMedia: e("./getusermedia"),
          };
        },
        { "../utils.js": 11, "./getusermedia": 4 },
      ],
      4: [
        function (e, t, r) {
          "use strict";
          var n = e("../utils.js").log,
            i = e("../utils.js").browserDetails;
          t.exports = function () {
            var e = function (e) {
                if ("object" != typeof e || e.mandatory || e.optional) return e;
                var t = {};
                return (
                  Object.keys(e).forEach(function (r) {
                    if (
                      "require" !== r &&
                      "advanced" !== r &&
                      "mediaSource" !== r
                    ) {
                      var n = "object" == typeof e[r] ? e[r] : { ideal: e[r] };
                      void 0 !== n.exact &&
                        "number" == typeof n.exact &&
                        (n.min = n.max = n.exact);
                      var i = function (e, t) {
                        return e
                          ? e + t.charAt(0).toUpperCase() + t.slice(1)
                          : "deviceId" === t
                          ? "sourceId"
                          : t;
                      };
                      if (void 0 !== n.ideal) {
                        t.optional = t.optional || [];
                        var a = {};
                        "number" == typeof n.ideal
                          ? ((a[i("min", r)] = n.ideal),
                            t.optional.push(a),
                            (a = {}),
                            (a[i("max", r)] = n.ideal),
                            t.optional.push(a))
                          : ((a[i("", r)] = n.ideal), t.optional.push(a));
                      }
                      void 0 !== n.exact && "number" != typeof n.exact
                        ? ((t.mandatory = t.mandatory || {}),
                          (t.mandatory[i("", r)] = n.exact))
                        : ["min", "max"].forEach(function (e) {
                            void 0 !== n[e] &&
                              ((t.mandatory = t.mandatory || {}),
                              (t.mandatory[i(e, r)] = n[e]));
                          });
                    }
                  }),
                  e.advanced &&
                    (t.optional = (t.optional || []).concat(e.advanced)),
                  t
                );
              },
              t = function (t, r) {
                if (
                  ((t = JSON.parse(JSON.stringify(t))),
                  t && t.audio && (t.audio = e(t.audio)),
                  t && "object" == typeof t.video)
                ) {
                  var a = t.video.facingMode;
                  a = a && ("object" == typeof a ? a : { ideal: a });
                  var o = i.version < 61;
                  if (
                    a &&
                    ("user" === a.exact ||
                      "environment" === a.exact ||
                      "user" === a.ideal ||
                      "environment" === a.ideal) &&
                    (!navigator.mediaDevices.getSupportedConstraints ||
                      !navigator.mediaDevices.getSupportedConstraints()
                        .facingMode ||
                      o)
                  ) {
                    delete t.video.facingMode;
                    var s;
                    if (
                      ("environment" === a.exact || "environment" === a.ideal
                        ? (s = ["back", "rear"])
                        : ("user" !== a.exact && "user" !== a.ideal) ||
                          (s = ["front"]),
                      s)
                    )
                      return navigator.mediaDevices
                        .enumerateDevices()
                        .then(function (i) {
                          i = i.filter(function (e) {
                            return "videoinput" === e.kind;
                          });
                          var o = i.find(function (e) {
                            return s.some(function (t) {
                              return -1 !== e.label.toLowerCase().indexOf(t);
                            });
                          });
                          return (
                            !o &&
                              i.length &&
                              -1 !== s.indexOf("back") &&
                              (o = i[i.length - 1]),
                            o &&
                              (t.video.deviceId = a.exact
                                ? { exact: o.deviceId }
                                : { ideal: o.deviceId }),
                            (t.video = e(t.video)),
                            n("chrome: " + JSON.stringify(t)),
                            r(t)
                          );
                        });
                  }
                  t.video = e(t.video);
                }
                return n("chrome: " + JSON.stringify(t)), r(t);
              },
              r = function (e) {
                return {
                  name:
                    {
                      PermissionDeniedError: "NotAllowedError",
                      ConstraintNotSatisfiedError: "OverconstrainedError",
                    }[e.name] || e.name,
                  message: e.message,
                  constraint: e.constraintName,
                  toString: function () {
                    return this.name + (this.message && ": ") + this.message;
                  },
                };
              },
              a = function (e, n, i) {
                t(e, function (e) {
                  navigator.webkitGetUserMedia(e, n, function (e) {
                    i(r(e));
                  });
                });
              };
            navigator.getUserMedia = a;
            var o = function (e) {
              return new Promise(function (t, r) {
                navigator.getUserMedia(e, t, r);
              });
            };
            if (
              (navigator.mediaDevices ||
                (navigator.mediaDevices = {
                  getUserMedia: o,
                  enumerateDevices: function () {
                    return new Promise(function (e) {
                      var t = { audio: "audioinput", video: "videoinput" };
                      return MediaStreamTrack.getSources(function (r) {
                        e(
                          r.map(function (e) {
                            return {
                              label: e.label,
                              kind: t[e.kind],
                              deviceId: e.id,
                              groupId: "",
                            };
                          })
                        );
                      });
                    });
                  },
                  getSupportedConstraints: function () {
                    return {
                      deviceId: !0,
                      echoCancellation: !0,
                      facingMode: !0,
                      frameRate: !0,
                      height: !0,
                      width: !0,
                    };
                  },
                }),
              navigator.mediaDevices.getUserMedia)
            ) {
              var s = navigator.mediaDevices.getUserMedia.bind(
                navigator.mediaDevices
              );
              navigator.mediaDevices.getUserMedia = function (e) {
                return t(e, function (e) {
                  return s(e).then(
                    function (t) {
                      if (
                        (e.audio && !t.getAudioTracks().length) ||
                        (e.video && !t.getVideoTracks().length)
                      )
                        throw (
                          (t.getTracks().forEach(function (e) {
                            e.stop();
                          }),
                          new DOMException("", "NotFoundError"))
                        );
                      return t;
                    },
                    function (e) {
                      return Promise.reject(r(e));
                    }
                  );
                });
              };
            } else
              navigator.mediaDevices.getUserMedia = function (e) {
                return o(e);
              };
            void 0 === navigator.mediaDevices.addEventListener &&
              (navigator.mediaDevices.addEventListener = function () {
                n("Dummy mediaDevices.addEventListener called.");
              }),
              void 0 === navigator.mediaDevices.removeEventListener &&
                (navigator.mediaDevices.removeEventListener = function () {
                  n("Dummy mediaDevices.removeEventListener called.");
                });
          };
        },
        { "../utils.js": 11 },
      ],
      5: [
        function (e, t, r) {
          "use strict";
          var n = e("../utils").browserDetails,
            i = e("./rtcpeerconnection_shim");
          t.exports = {
            shimGetUserMedia: e("./getusermedia"),
            shimPeerConnection: function () {
              if (
                window.RTCIceGatherer &&
                (window.RTCIceCandidate ||
                  (window.RTCIceCandidate = function (e) {
                    return e;
                  }),
                window.RTCSessionDescription ||
                  (window.RTCSessionDescription = function (e) {
                    return e;
                  }),
                n.version < 15025)
              ) {
                var e = Object.getOwnPropertyDescriptor(
                  MediaStreamTrack.prototype,
                  "enabled"
                );
                Object.defineProperty(MediaStreamTrack.prototype, "enabled", {
                  set: function (t) {
                    e.set.call(this, t);
                    var r = new Event("enabled");
                    (r.enabled = t), this.dispatchEvent(r);
                  },
                });
              }
              window.RTCPeerConnection = i(n.version);
            },
            shimReplaceTrack: function () {
              !window.RTCRtpSender ||
                "replaceTrack" in RTCRtpSender.prototype ||
                (RTCRtpSender.prototype.replaceTrack =
                  RTCRtpSender.prototype.setTrack);
            },
          };
        },
        { "../utils": 11, "./getusermedia": 6, "./rtcpeerconnection_shim": 7 },
      ],
      6: [
        function (e, t, r) {
          "use strict";
          t.exports = function () {
            var e = function (e) {
                return {
                  name:
                    { PermissionDeniedError: "NotAllowedError" }[e.name] ||
                    e.name,
                  message: e.message,
                  constraint: e.constraint,
                  toString: function () {
                    return this.name;
                  },
                };
              },
              t = navigator.mediaDevices.getUserMedia.bind(
                navigator.mediaDevices
              );
            navigator.mediaDevices.getUserMedia = function (r) {
              return t(r).catch(function (t) {
                return Promise.reject(e(t));
              });
            };
          };
        },
        {},
      ],
      7: [
        function (e, t, r) {
          "use strict";
          function n(e) {
            var t = e.filter(function (e) {
                return "audio" === e.kind;
              }),
              r = e.filter(function (e) {
                return "video" === e.kind;
              });
            for (e = []; t.length || r.length; )
              t.length && e.push(t.shift()), r.length && e.push(r.shift());
            return e;
          }
          function i(e, t) {
            var r = !1;
            return (
              (e = JSON.parse(JSON.stringify(e))),
              e.filter(function (e) {
                if (e && (e.urls || e.url)) {
                  var n = e.urls || e.url;
                  e.url &&
                    !e.urls &&
                    console.warn(
                      "RTCIceServer.url is deprecated! Use urls instead."
                    );
                  var i = "string" == typeof n;
                  return (
                    i && (n = [n]),
                    (n = n.filter(function (e) {
                      return 0 !== e.indexOf("turn:") ||
                        -1 === e.indexOf("transport=udp") ||
                        -1 !== e.indexOf("turn:[") ||
                        r
                        ? 0 === e.indexOf("stun:") && t >= 14393
                        : ((r = !0), !0);
                    })),
                    delete e.url,
                    (e.urls = i ? n[0] : n),
                    !!n.length
                  );
                }
                return !1;
              })
            );
          }
          var a = e("sdp");
          t.exports = function (e) {
            var t = function (t) {
              var r = this,
                n = document.createDocumentFragment();
              if (
                ([
                  "addEventListener",
                  "removeEventListener",
                  "dispatchEvent",
                ].forEach(function (e) {
                  r[e] = n[e].bind(n);
                }),
                (this.onicecandidate = null),
                (this.onaddstream = null),
                (this.ontrack = null),
                (this.onremovestream = null),
                (this.onsignalingstatechange = null),
                (this.oniceconnectionstatechange = null),
                (this.onicegatheringstatechange = null),
                (this.onnegotiationneeded = null),
                (this.ondatachannel = null),
                (this.canTrickleIceCandidates = null),
                (this.localStreams = []),
                (this.remoteStreams = []),
                (this.getLocalStreams = function () {
                  return r.localStreams;
                }),
                (this.getRemoteStreams = function () {
                  return r.remoteStreams;
                }),
                (this.localDescription = new RTCSessionDescription({
                  type: "",
                  sdp: "",
                })),
                (this.remoteDescription = new RTCSessionDescription({
                  type: "",
                  sdp: "",
                })),
                (this.signalingState = "stable"),
                (this.iceConnectionState = "new"),
                (this.iceGatheringState = "new"),
                (this.iceOptions = { gatherPolicy: "all", iceServers: [] }),
                t && t.iceTransportPolicy)
              )
                switch (t.iceTransportPolicy) {
                  case "all":
                  case "relay":
                    this.iceOptions.gatherPolicy = t.iceTransportPolicy;
                }
              (this.usingBundle = t && "max-bundle" === t.bundlePolicy),
                t &&
                  t.iceServers &&
                  (this.iceOptions.iceServers = i(t.iceServers, e)),
                (this._config = t || {}),
                (this.transceivers = []),
                (this._localIceCandidatesBuffer = []);
            };
            return (
              (t.prototype._emitGatheringStateChange = function () {
                var e = new Event("icegatheringstatechange");
                this.dispatchEvent(e),
                  null !== this.onicegatheringstatechange &&
                    this.onicegatheringstatechange(e);
              }),
              (t.prototype._emitBufferedCandidates = function () {
                var e = this,
                  t = a.splitSections(e.localDescription.sdp);
                this._localIceCandidatesBuffer.forEach(function (r) {
                  if (r.candidate && 0 !== Object.keys(r.candidate).length)
                    t[r.candidate.sdpMLineIndex + 1] +=
                      "a=" + r.candidate.candidate + "\r\n";
                  else
                    for (var n = 1; n < t.length; n++)
                      -1 === t[n].indexOf("\r\na=end-of-candidates\r\n") &&
                        (t[n] += "a=end-of-candidates\r\n");
                  if (
                    ((e.localDescription.sdp = t.join("")),
                    e.dispatchEvent(r),
                    null !== e.onicecandidate && e.onicecandidate(r),
                    !r.candidate && "complete" !== e.iceGatheringState)
                  ) {
                    e.transceivers.every(function (e) {
                      return (
                        e.iceGatherer && "completed" === e.iceGatherer.state
                      );
                    }) &&
                      "complete" !== e.iceGatheringStateChange &&
                      ((e.iceGatheringState = "complete"),
                      e._emitGatheringStateChange());
                  }
                }),
                  (this._localIceCandidatesBuffer = []);
              }),
              (t.prototype.getConfiguration = function () {
                return this._config;
              }),
              (t.prototype.addStream = function (t) {
                if (e >= 15025) this.localStreams.push(t);
                else {
                  var r = t.clone();
                  t.getTracks().forEach(function (e, t) {
                    var n = r.getTracks()[t];
                    e.addEventListener("enabled", function (e) {
                      n.enabled = e.enabled;
                    });
                  }),
                    this.localStreams.push(r);
                }
                this._maybeFireNegotiationNeeded();
              }),
              (t.prototype.removeStream = function (e) {
                var t = this.localStreams.indexOf(e);
                t > -1 &&
                  (this.localStreams.splice(t, 1),
                  this._maybeFireNegotiationNeeded());
              }),
              (t.prototype.getSenders = function () {
                return this.transceivers
                  .filter(function (e) {
                    return !!e.rtpSender;
                  })
                  .map(function (e) {
                    return e.rtpSender;
                  });
              }),
              (t.prototype.getReceivers = function () {
                return this.transceivers
                  .filter(function (e) {
                    return !!e.rtpReceiver;
                  })
                  .map(function (e) {
                    return e.rtpReceiver;
                  });
              }),
              (t.prototype._getCommonCapabilities = function (e, t) {
                var r = { codecs: [], headerExtensions: [], fecMechanisms: [] },
                  n = function (e, t) {
                    e = parseInt(e, 10);
                    for (var r = 0; r < t.length; r++)
                      if (
                        t[r].payloadType === e ||
                        t[r].preferredPayloadType === e
                      )
                        return t[r];
                  },
                  i = function (e, t, r, i) {
                    var a = n(e.parameters.apt, r),
                      o = n(t.parameters.apt, i);
                    return (
                      a && o && a.name.toLowerCase() === o.name.toLowerCase()
                    );
                  };
                return (
                  e.codecs.forEach(function (n) {
                    for (var a = 0; a < t.codecs.length; a++) {
                      var o = t.codecs[a];
                      if (
                        n.name.toLowerCase() === o.name.toLowerCase() &&
                        n.clockRate === o.clockRate
                      ) {
                        if (
                          "rtx" === n.name.toLowerCase() &&
                          n.parameters &&
                          o.parameters.apt &&
                          !i(n, o, e.codecs, t.codecs)
                        )
                          continue;
                        (o = JSON.parse(JSON.stringify(o))),
                          (o.numChannels = Math.min(
                            n.numChannels,
                            o.numChannels
                          )),
                          r.codecs.push(o),
                          (o.rtcpFeedback = o.rtcpFeedback.filter(function (e) {
                            for (var t = 0; t < n.rtcpFeedback.length; t++)
                              if (
                                n.rtcpFeedback[t].type === e.type &&
                                n.rtcpFeedback[t].parameter === e.parameter
                              )
                                return !0;
                            return !1;
                          }));
                        break;
                      }
                    }
                  }),
                  e.headerExtensions.forEach(function (e) {
                    for (var n = 0; n < t.headerExtensions.length; n++) {
                      var i = t.headerExtensions[n];
                      if (e.uri === i.uri) {
                        r.headerExtensions.push(i);
                        break;
                      }
                    }
                  }),
                  r
                );
              }),
              (t.prototype._createIceAndDtlsTransports = function (e, t) {
                var r = this,
                  n = new RTCIceGatherer(r.iceOptions),
                  i = new RTCIceTransport(n);
                (n.onlocalcandidate = function (o) {
                  var s = new Event("icecandidate");
                  s.candidate = { sdpMid: e, sdpMLineIndex: t };
                  var c = o.candidate,
                    d = !c || 0 === Object.keys(c).length;
                  d
                    ? void 0 === n.state && (n.state = "completed")
                    : ((c.component = "RTCP" === i.component ? 2 : 1),
                      (s.candidate.candidate = a.writeCandidate(c)));
                  var p = a.splitSections(r.localDescription.sdp);
                  (p[s.candidate.sdpMLineIndex + 1] += d
                    ? "a=end-of-candidates\r\n"
                    : "a=" + s.candidate.candidate + "\r\n"),
                    (r.localDescription.sdp = p.join(""));
                  var u = r._pendingOffer ? r._pendingOffer : r.transceivers,
                    f = u.every(function (e) {
                      return (
                        e.iceGatherer && "completed" === e.iceGatherer.state
                      );
                    });
                  switch (r.iceGatheringState) {
                    case "new":
                      d || r._localIceCandidatesBuffer.push(s),
                        d &&
                          f &&
                          r._localIceCandidatesBuffer.push(
                            new Event("icecandidate")
                          );
                      break;
                    case "gathering":
                      r._emitBufferedCandidates(),
                        d ||
                          (r.dispatchEvent(s),
                          null !== r.onicecandidate && r.onicecandidate(s)),
                        f &&
                          (r.dispatchEvent(new Event("icecandidate")),
                          null !== r.onicecandidate &&
                            r.onicecandidate(new Event("icecandidate")),
                          (r.iceGatheringState = "complete"),
                          r._emitGatheringStateChange());
                  }
                }),
                  (i.onicestatechange = function () {
                    r._updateConnectionState();
                  });
                var o = new RTCDtlsTransport(i);
                return (
                  (o.ondtlsstatechange = function () {
                    r._updateConnectionState();
                  }),
                  (o.onerror = function () {
                    (o.state = "failed"), r._updateConnectionState();
                  }),
                  { iceGatherer: n, iceTransport: i, dtlsTransport: o }
                );
              }),
              (t.prototype._disposeIceAndDtlsTransports = function (e) {
                var t = this.transceivers[e].iceGatherer;
                t &&
                  (delete t.onlocalcandidate,
                  delete this.transceivers[e].iceGatherer);
                var r = this.transceivers[e].iceTransport;
                r &&
                  (delete r.onicestatechange,
                  delete this.transceivers[e].iceTransport);
                var n = this.transceivers[e].dtlsTransport;
                n &&
                  (delete n.ondtlssttatechange,
                  delete n.onerror,
                  delete this.transceivers[e].dtlsTransport);
              }),
              (t.prototype._transceive = function (t, r, n) {
                var i = this._getCommonCapabilities(
                  t.localCapabilities,
                  t.remoteCapabilities
                );
                r &&
                  t.rtpSender &&
                  ((i.encodings = t.sendEncodingParameters),
                  (i.rtcp = {
                    cname: a.localCName,
                    compound: t.rtcpParameters.compound,
                  }),
                  t.recvEncodingParameters.length &&
                    (i.rtcp.ssrc = t.recvEncodingParameters[0].ssrc),
                  t.rtpSender.send(i)),
                  n &&
                    t.rtpReceiver &&
                    ("video" === t.kind &&
                      t.recvEncodingParameters &&
                      e < 15019 &&
                      t.recvEncodingParameters.forEach(function (e) {
                        delete e.rtx;
                      }),
                    (i.encodings = t.recvEncodingParameters),
                    (i.rtcp = {
                      cname: t.rtcpParameters.cname,
                      compound: t.rtcpParameters.compound,
                    }),
                    t.sendEncodingParameters.length &&
                      (i.rtcp.ssrc = t.sendEncodingParameters[0].ssrc),
                    t.rtpReceiver.receive(i));
              }),
              (t.prototype.setLocalDescription = function (e) {
                var t,
                  r,
                  n = this;
                if ("offer" === e.type)
                  this._pendingOffer &&
                    ((t = a.splitSections(e.sdp)),
                    (r = t.shift()),
                    t.forEach(function (e, t) {
                      var r = a.parseRtpParameters(e);
                      n._pendingOffer[t].localCapabilities = r;
                    }),
                    (this.transceivers = this._pendingOffer),
                    delete this._pendingOffer);
                else if ("answer" === e.type) {
                  (t = a.splitSections(n.remoteDescription.sdp)),
                    (r = t.shift());
                  var i = a.matchPrefix(r, "a=ice-lite").length > 0;
                  t.forEach(function (e, t) {
                    var o = n.transceivers[t],
                      s = o.iceGatherer,
                      c = o.iceTransport,
                      d = o.dtlsTransport,
                      p = o.localCapabilities,
                      u = o.remoteCapabilities;
                    if (!a.isRejected(e) && !o.isDatachannel) {
                      var f = a.getIceParameters(e, r),
                        l = a.getDtlsParameters(e, r);
                      i && (l.role = "server"),
                        (n.usingBundle && 0 !== t) ||
                          (c.start(s, f, i ? "controlling" : "controlled"),
                          d.start(l));
                      var m = n._getCommonCapabilities(p, u);
                      n._transceive(o, m.codecs.length > 0, !1);
                    }
                  });
                }
                switch (
                  ((this.localDescription = { type: e.type, sdp: e.sdp }),
                  e.type)
                ) {
                  case "offer":
                    this._updateSignalingState("have-local-offer");
                    break;
                  case "answer":
                    this._updateSignalingState("stable");
                    break;
                  default:
                    throw new TypeError('unsupported type "' + e.type + '"');
                }
                var o =
                  arguments.length > 1 && "function" == typeof arguments[1];
                if (o) {
                  var s = arguments[1];
                  window.setTimeout(function () {
                    s(),
                      "new" === n.iceGatheringState &&
                        ((n.iceGatheringState = "gathering"),
                        n._emitGatheringStateChange()),
                      n._emitBufferedCandidates();
                  }, 0);
                }
                var c = Promise.resolve();
                return (
                  c.then(function () {
                    o ||
                      ("new" === n.iceGatheringState &&
                        ((n.iceGatheringState = "gathering"),
                        n._emitGatheringStateChange()),
                      window.setTimeout(
                        n._emitBufferedCandidates.bind(n),
                        500
                      ));
                  }),
                  c
                );
              }),
              (t.prototype.setRemoteDescription = function (t) {
                var r = this,
                  n = {},
                  i = [],
                  o = a.splitSections(t.sdp),
                  s = o.shift(),
                  c = a.matchPrefix(s, "a=ice-lite").length > 0,
                  d = a.matchPrefix(s, "a=group:BUNDLE ").length > 0,
                  p = a.matchPrefix(s, "a=ice-options:")[0];
                switch (
                  ((this.canTrickleIceCandidates =
                    !!p && p.substr(14).split(" ").indexOf("trickle") >= 0),
                  o.forEach(function (o, p) {
                    var u = a.splitLines(o),
                      f = a.getKind(o),
                      l = a.isRejected(o),
                      m = u[0].substr(2).split(" ")[2],
                      h = a.getDirection(o, s),
                      v = a.parseMsid(o),
                      g = a.getMid(o) || a.generateIdentifier();
                    if ("application" === f && "DTLS/SCTP" === m)
                      return void (r.transceivers[p] = {
                        mid: g,
                        isDatachannel: !0,
                      });
                    var w,
                      y,
                      C,
                      b,
                      T,
                      P,
                      S,
                      R,
                      E,
                      k,
                      x,
                      O,
                      D = a.parseRtpParameters(o);
                    l ||
                      ((x = a.getIceParameters(o, s)),
                      (O = a.getDtlsParameters(o, s)),
                      (O.role = "client")),
                      (R = a.parseRtpEncodingParameters(o));
                    var M = a.parseRtcpParameters(o),
                      L = a.matchPrefix(o, "a=end-of-candidates", s).length > 0,
                      j = a
                        .matchPrefix(o, "a=candidate:")
                        .map(function (e) {
                          return a.parseCandidate(e);
                        })
                        .filter(function (e) {
                          return "1" === e.component;
                        });
                    if ("offer" !== t.type || l)
                      "answer" !== t.type ||
                        l ||
                        (d &&
                          p > 0 &&
                          (r._disposeIceAndDtlsTransports(p),
                          (r.transceivers[p].iceGatherer =
                            r.transceivers[0].iceGatherer),
                          (r.transceivers[p].iceTransport =
                            r.transceivers[0].iceTransport),
                          (r.transceivers[p].dtlsTransport =
                            r.transceivers[0].dtlsTransport),
                          r.transceivers[p].rtpSender &&
                            r.transceivers[p].rtpSender.setTransport(
                              r.transceivers[0].dtlsTransport
                            ),
                          r.transceivers[p].rtpReceiver &&
                            r.transceivers[p].rtpReceiver.setTransport(
                              r.transceivers[0].dtlsTransport
                            )),
                        (w = r.transceivers[p]),
                        (y = w.iceGatherer),
                        (C = w.iceTransport),
                        (b = w.dtlsTransport),
                        (T = w.rtpSender),
                        (P = w.rtpReceiver),
                        (S = w.sendEncodingParameters),
                        (E = w.localCapabilities),
                        (r.transceivers[p].recvEncodingParameters = R),
                        (r.transceivers[p].remoteCapabilities = D),
                        (r.transceivers[p].rtcpParameters = M),
                        (c || L) && j.length && C.setRemoteCandidates(j),
                        (d && 0 !== p) ||
                          (C.start(y, x, "controlling"), b.start(O)),
                        r._transceive(
                          w,
                          "sendrecv" === h || "recvonly" === h,
                          "sendrecv" === h || "sendonly" === h
                        ),
                        !P || ("sendrecv" !== h && "sendonly" !== h)
                          ? delete w.rtpReceiver
                          : ((k = P.track),
                            v
                              ? (n[v.stream] ||
                                  (n[v.stream] = new MediaStream()),
                                n[v.stream].addTrack(k),
                                i.push([k, P, n[v.stream]]))
                              : (n.default || (n.default = new MediaStream()),
                                n.default.addTrack(k),
                                i.push([k, P, n.default]))));
                    else {
                      var _ =
                        d && p > 0
                          ? {
                              iceGatherer: r.transceivers[0].iceGatherer,
                              iceTransport: r.transceivers[0].iceTransport,
                              dtlsTransport: r.transceivers[0].dtlsTransport,
                            }
                          : r._createIceAndDtlsTransports(g, p);
                      if (
                        (!L ||
                          (d && 0 !== p) ||
                          _.iceTransport.setRemoteCandidates(j),
                        (E = RTCRtpReceiver.getCapabilities(f)),
                        e < 15019 &&
                          (E.codecs = E.codecs.filter(function (e) {
                            return "rtx" !== e.name;
                          })),
                        (S = [{ ssrc: 1001 * (2 * p + 2) }]),
                        ("sendrecv" !== h && "sendonly" !== h) ||
                          ((P = new RTCRtpReceiver(_.dtlsTransport, f)),
                          (k = P.track),
                          v
                            ? (n[v.stream] ||
                                ((n[v.stream] = new MediaStream()),
                                Object.defineProperty(n[v.stream], "id", {
                                  get: function () {
                                    return v.stream;
                                  },
                                })),
                              Object.defineProperty(k, "id", {
                                get: function () {
                                  return v.track;
                                },
                              }),
                              n[v.stream].addTrack(k),
                              i.push([k, P, n[v.stream]]))
                            : (n.default || (n.default = new MediaStream()),
                              n.default.addTrack(k),
                              i.push([k, P, n.default]))),
                        r.localStreams.length > 0 &&
                          r.localStreams[0].getTracks().length >= p)
                      ) {
                        var U;
                        "audio" === f
                          ? (U = r.localStreams[0].getAudioTracks()[0])
                          : "video" === f &&
                            (U = r.localStreams[0].getVideoTracks()[0]),
                          U &&
                            (e >= 15019 &&
                              "video" === f &&
                              (S[0].rtx = { ssrc: 1001 * (2 * p + 2) + 1 }),
                            (T = new RTCRtpSender(U, _.dtlsTransport)));
                      }
                      (r.transceivers[p] = {
                        iceGatherer: _.iceGatherer,
                        iceTransport: _.iceTransport,
                        dtlsTransport: _.dtlsTransport,
                        localCapabilities: E,
                        remoteCapabilities: D,
                        rtpSender: T,
                        rtpReceiver: P,
                        kind: f,
                        mid: g,
                        rtcpParameters: M,
                        sendEncodingParameters: S,
                        recvEncodingParameters: R,
                      }),
                        r._transceive(
                          r.transceivers[p],
                          !1,
                          "sendrecv" === h || "sendonly" === h
                        );
                    }
                  }),
                  (this.usingBundle = d),
                  (this.remoteDescription = { type: t.type, sdp: t.sdp }),
                  t.type)
                ) {
                  case "offer":
                    this._updateSignalingState("have-remote-offer");
                    break;
                  case "answer":
                    this._updateSignalingState("stable");
                    break;
                  default:
                    throw new TypeError('unsupported type "' + t.type + '"');
                }
                return (
                  Object.keys(n).forEach(function (e) {
                    var t = n[e];
                    if (t.getTracks().length) {
                      r.remoteStreams.push(t);
                      var a = new Event("addstream");
                      (a.stream = t),
                        r.dispatchEvent(a),
                        null !== r.onaddstream &&
                          window.setTimeout(function () {
                            r.onaddstream(a);
                          }, 0),
                        i.forEach(function (e) {
                          var n = e[0],
                            i = e[1];
                          if (t.id === e[2].id) {
                            var a = new Event("track");
                            (a.track = n),
                              (a.receiver = i),
                              (a.streams = [t]),
                              r.dispatchEvent(a),
                              null !== r.ontrack &&
                                window.setTimeout(function () {
                                  r.ontrack(a);
                                }, 0);
                          }
                        });
                    }
                  }),
                  arguments.length > 1 &&
                    "function" == typeof arguments[1] &&
                    window.setTimeout(arguments[1], 0),
                  Promise.resolve()
                );
              }),
              (t.prototype.close = function () {
                this.transceivers.forEach(function (e) {
                  e.iceTransport && e.iceTransport.stop(),
                    e.dtlsTransport && e.dtlsTransport.stop(),
                    e.rtpSender && e.rtpSender.stop(),
                    e.rtpReceiver && e.rtpReceiver.stop();
                }),
                  this._updateSignalingState("closed");
              }),
              (t.prototype._updateSignalingState = function (e) {
                this.signalingState = e;
                var t = new Event("signalingstatechange");
                this.dispatchEvent(t),
                  null !== this.onsignalingstatechange &&
                    this.onsignalingstatechange(t);
              }),
              (t.prototype._maybeFireNegotiationNeeded = function () {
                var e = new Event("negotiationneeded");
                this.dispatchEvent(e),
                  null !== this.onnegotiationneeded &&
                    this.onnegotiationneeded(e);
              }),
              (t.prototype._updateConnectionState = function () {
                var e,
                  t = this,
                  r = {
                    new: 0,
                    closed: 0,
                    connecting: 0,
                    checking: 0,
                    connected: 0,
                    completed: 0,
                    failed: 0,
                  };
                if (
                  (this.transceivers.forEach(function (e) {
                    r[e.iceTransport.state]++, r[e.dtlsTransport.state]++;
                  }),
                  (r.connected += r.completed),
                  (e = "new"),
                  r.failed > 0
                    ? (e = "failed")
                    : r.connecting > 0 || r.checking > 0
                    ? (e = "connecting")
                    : r.disconnected > 0
                    ? (e = "disconnected")
                    : r.new > 0
                    ? (e = "new")
                    : (r.connected > 0 || r.completed > 0) && (e = "connected"),
                  e !== t.iceConnectionState)
                ) {
                  t.iceConnectionState = e;
                  var n = new Event("iceconnectionstatechange");
                  this.dispatchEvent(n),
                    null !== this.oniceconnectionstatechange &&
                      this.oniceconnectionstatechange(n);
                }
              }),
              (t.prototype.createOffer = function () {
                var t = this;
                if (this._pendingOffer)
                  throw new Error(
                    "createOffer called while there is a pending offer."
                  );
                var r;
                1 === arguments.length && "function" != typeof arguments[0]
                  ? (r = arguments[0])
                  : 3 === arguments.length && (r = arguments[2]);
                var i = [],
                  o = 0,
                  s = 0;
                if (
                  (this.localStreams.length &&
                    ((o = this.localStreams.reduce(function (e, t) {
                      return e + t.getAudioTracks().length;
                    }, 0)),
                    (s = this.localStreams.reduce(function (e, t) {
                      return e + t.getVideoTracks().length;
                    }, 0))),
                  r)
                ) {
                  if (r.mandatory || r.optional)
                    throw new TypeError(
                      "Legacy mandatory/optional constraints not supported."
                    );
                  void 0 !== r.offerToReceiveAudio &&
                    (o =
                      !0 === r.offerToReceiveAudio
                        ? 1
                        : !1 === r.offerToReceiveAudio
                        ? 0
                        : r.offerToReceiveAudio),
                    void 0 !== r.offerToReceiveVideo &&
                      (s =
                        !0 === r.offerToReceiveVideo
                          ? 1
                          : !1 === r.offerToReceiveVideo
                          ? 0
                          : r.offerToReceiveVideo);
                }
                for (
                  this.localStreams.forEach(function (e) {
                    e.getTracks().forEach(function (t) {
                      i.push({
                        kind: t.kind,
                        track: t,
                        stream: e,
                        wantReceive: "audio" === t.kind ? o > 0 : s > 0,
                      }),
                        "audio" === t.kind ? o-- : "video" === t.kind && s--;
                    });
                  });
                  o > 0 || s > 0;

                )
                  o > 0 && (i.push({ kind: "audio", wantReceive: !0 }), o--),
                    s > 0 && (i.push({ kind: "video", wantReceive: !0 }), s--);
                i = n(i);
                var c = a.writeSessionBoilerplate(),
                  d = [];
                i.forEach(function (r, n) {
                  var i = r.track,
                    o = r.kind,
                    s = a.generateIdentifier(),
                    c =
                      t.usingBundle && n > 0
                        ? {
                            iceGatherer: d[0].iceGatherer,
                            iceTransport: d[0].iceTransport,
                            dtlsTransport: d[0].dtlsTransport,
                          }
                        : t._createIceAndDtlsTransports(s, n),
                    p = RTCRtpSender.getCapabilities(o);
                  e < 15019 &&
                    (p.codecs = p.codecs.filter(function (e) {
                      return "rtx" !== e.name;
                    })),
                    p.codecs.forEach(function (e) {
                      "H264" === e.name &&
                        void 0 === e.parameters["level-asymmetry-allowed"] &&
                        (e.parameters["level-asymmetry-allowed"] = "1");
                    });
                  var u,
                    f,
                    l = [{ ssrc: 1001 * (2 * n + 1) }];
                  i &&
                    (e >= 15019 &&
                      "video" === o &&
                      (l[0].rtx = { ssrc: 1001 * (2 * n + 1) + 1 }),
                    (u = new RTCRtpSender(i, c.dtlsTransport))),
                    r.wantReceive &&
                      (f = new RTCRtpReceiver(c.dtlsTransport, o)),
                    (d[n] = {
                      iceGatherer: c.iceGatherer,
                      iceTransport: c.iceTransport,
                      dtlsTransport: c.dtlsTransport,
                      localCapabilities: p,
                      remoteCapabilities: null,
                      rtpSender: u,
                      rtpReceiver: f,
                      kind: o,
                      mid: s,
                      sendEncodingParameters: l,
                      recvEncodingParameters: null,
                    });
                }),
                  "max-compat" !== this._config.bundlePolicy &&
                    (c +=
                      "a=group:BUNDLE " +
                      d
                        .map(function (e) {
                          return e.mid;
                        })
                        .join(" ") +
                      "\r\n"),
                  (c += "a=ice-options:trickle\r\n"),
                  i.forEach(function (e, t) {
                    var r = d[t];
                    (c += a.writeMediaSection(
                      r,
                      r.localCapabilities,
                      "offer",
                      e.stream
                    )),
                      (c += "a=rtcp-rsize\r\n");
                  }),
                  (this._pendingOffer = d);
                var p = new RTCSessionDescription({ type: "offer", sdp: c });
                return (
                  arguments.length &&
                    "function" == typeof arguments[0] &&
                    window.setTimeout(arguments[0], 0, p),
                  Promise.resolve(p)
                );
              }),
              (t.prototype.createAnswer = function () {
                var e = this,
                  t = a.writeSessionBoilerplate();
                this.usingBundle &&
                  (t +=
                    "a=group:BUNDLE " +
                    this.transceivers
                      .map(function (e) {
                        return e.mid;
                      })
                      .join(" ") +
                    "\r\n"),
                  this.transceivers.forEach(function (r) {
                    if (r.isDatachannel)
                      return void (t +=
                        "m=application 0 DTLS/SCTP 5000\r\nc=IN IP4 0.0.0.0\r\na=mid:" +
                        r.mid +
                        "\r\n");
                    var n = e._getCommonCapabilities(
                      r.localCapabilities,
                      r.remoteCapabilities
                    );
                    !n.codecs.filter(function (e) {
                      return "rtx" === e.name.toLowerCase();
                    }).length &&
                      r.sendEncodingParameters[0].rtx &&
                      delete r.sendEncodingParameters[0].rtx,
                      (t += a.writeMediaSection(
                        r,
                        n,
                        "answer",
                        e.localStreams[0]
                      )),
                      r.rtcpParameters &&
                        r.rtcpParameters.reducedSize &&
                        (t += "a=rtcp-rsize\r\n");
                  });
                var r = new RTCSessionDescription({ type: "answer", sdp: t });
                return (
                  arguments.length &&
                    "function" == typeof arguments[0] &&
                    window.setTimeout(arguments[0], 0, r),
                  Promise.resolve(r)
                );
              }),
              (t.prototype.addIceCandidate = function (e) {
                if (e) {
                  var t = e.sdpMLineIndex;
                  if (e.sdpMid)
                    for (var r = 0; r < this.transceivers.length; r++)
                      if (this.transceivers[r].mid === e.sdpMid) {
                        t = r;
                        break;
                      }
                  var n = this.transceivers[t];
                  if (n) {
                    var i =
                      Object.keys(e.candidate).length > 0
                        ? a.parseCandidate(e.candidate)
                        : {};
                    if ("tcp" === i.protocol && (0 === i.port || 9 === i.port))
                      return Promise.resolve();
                    if ("1" !== i.component) return Promise.resolve();
                    n.iceTransport.addRemoteCandidate(i);
                    var o = a.splitSections(this.remoteDescription.sdp);
                    (o[t + 1] +=
                      (i.type ? e.candidate.trim() : "a=end-of-candidates") +
                      "\r\n"),
                      (this.remoteDescription.sdp = o.join(""));
                  }
                } else
                  for (var s = 0; s < this.transceivers.length; s++)
                    if (
                      (this.transceivers[s].iceTransport.addRemoteCandidate({}),
                      this.usingBundle)
                    )
                      return Promise.resolve();
                return (
                  arguments.length > 1 &&
                    "function" == typeof arguments[1] &&
                    window.setTimeout(arguments[1], 0),
                  Promise.resolve()
                );
              }),
              (t.prototype.getStats = function () {
                var e = [];
                this.transceivers.forEach(function (t) {
                  [
                    "rtpSender",
                    "rtpReceiver",
                    "iceGatherer",
                    "iceTransport",
                    "dtlsTransport",
                  ].forEach(function (r) {
                    t[r] && e.push(t[r].getStats());
                  });
                });
                var t =
                    arguments.length > 1 &&
                    "function" == typeof arguments[1] &&
                    arguments[1],
                  r = function (e) {
                    return (
                      {
                        inboundrtp: "inbound-rtp",
                        outboundrtp: "outbound-rtp",
                        candidatepair: "candidate-pair",
                        localcandidate: "local-candidate",
                        remotecandidate: "remote-candidate",
                      }[e.type] || e.type
                    );
                  };
                return new Promise(function (n) {
                  var i = new Map();
                  Promise.all(e).then(function (e) {
                    e.forEach(function (e) {
                      Object.keys(e).forEach(function (t) {
                        (e[t].type = r(e[t])), i.set(t, e[t]);
                      });
                    }),
                      t && window.setTimeout(t, 0, i),
                      n(i);
                  });
                });
              }),
              t
            );
          };
        },
        { sdp: 1 },
      ],
      8: [
        function (e, t, r) {
          "use strict";
          var n = e("../utils").browserDetails,
            i = {
              shimOnTrack: function () {
                "object" != typeof window ||
                  !window.RTCPeerConnection ||
                  "ontrack" in window.RTCPeerConnection.prototype ||
                  Object.defineProperty(
                    window.RTCPeerConnection.prototype,
                    "ontrack",
                    {
                      get: function () {
                        return this._ontrack;
                      },
                      set: function (e) {
                        this._ontrack &&
                          (this.removeEventListener("track", this._ontrack),
                          this.removeEventListener(
                            "addstream",
                            this._ontrackpoly
                          )),
                          this.addEventListener("track", (this._ontrack = e)),
                          this.addEventListener(
                            "addstream",
                            (this._ontrackpoly = function (e) {
                              e.stream.getTracks().forEach(
                                function (t) {
                                  var r = new Event("track");
                                  (r.track = t),
                                    (r.receiver = { track: t }),
                                    (r.streams = [e.stream]),
                                    this.dispatchEvent(r);
                                }.bind(this)
                              );
                            }.bind(this))
                          );
                      },
                    }
                  );
              },
              shimSourceObject: function () {
                "object" == typeof window &&
                  (!window.HTMLMediaElement ||
                    "srcObject" in window.HTMLMediaElement.prototype ||
                    Object.defineProperty(
                      window.HTMLMediaElement.prototype,
                      "srcObject",
                      {
                        get: function () {
                          return this.mozSrcObject;
                        },
                        set: function (e) {
                          this.mozSrcObject = e;
                        },
                      }
                    ));
              },
              shimPeerConnection: function () {
                if (
                  "object" == typeof window &&
                  (window.RTCPeerConnection || window.mozRTCPeerConnection)
                ) {
                  window.RTCPeerConnection ||
                    ((window.RTCPeerConnection = function (e, t) {
                      if (n.version < 38 && e && e.iceServers) {
                        for (var r = [], i = 0; i < e.iceServers.length; i++) {
                          var a = e.iceServers[i];
                          if (a.hasOwnProperty("urls"))
                            for (var o = 0; o < a.urls.length; o++) {
                              var s = { url: a.urls[o] };
                              0 === a.urls[o].indexOf("turn") &&
                                ((s.username = a.username),
                                (s.credential = a.credential)),
                                r.push(s);
                            }
                          else r.push(e.iceServers[i]);
                        }
                        e.iceServers = r;
                      }
                      return new mozRTCPeerConnection(e, t);
                    }),
                    (window.RTCPeerConnection.prototype =
                      mozRTCPeerConnection.prototype),
                    mozRTCPeerConnection.generateCertificate &&
                      Object.defineProperty(
                        window.RTCPeerConnection,
                        "generateCertificate",
                        {
                          get: function () {
                            return mozRTCPeerConnection.generateCertificate;
                          },
                        }
                      ),
                    (window.RTCSessionDescription = mozRTCSessionDescription),
                    (window.RTCIceCandidate = mozRTCIceCandidate)),
                    [
                      "setLocalDescription",
                      "setRemoteDescription",
                      "addIceCandidate",
                    ].forEach(function (e) {
                      var t = RTCPeerConnection.prototype[e];
                      RTCPeerConnection.prototype[e] = function () {
                        return (
                          (arguments[0] = new (
                            "addIceCandidate" === e
                              ? RTCIceCandidate
                              : RTCSessionDescription
                          )(arguments[0])),
                          t.apply(this, arguments)
                        );
                      };
                    });
                  var e = RTCPeerConnection.prototype.addIceCandidate;
                  RTCPeerConnection.prototype.addIceCandidate = function () {
                    return arguments[0]
                      ? e.apply(this, arguments)
                      : (arguments[1] && arguments[1].apply(null),
                        Promise.resolve());
                  };
                  var t = function (e) {
                      var t = new Map();
                      return (
                        Object.keys(e).forEach(function (r) {
                          t.set(r, e[r]), (t[r] = e[r]);
                        }),
                        t
                      );
                    },
                    r = {
                      inboundrtp: "inbound-rtp",
                      outboundrtp: "outbound-rtp",
                      candidatepair: "candidate-pair",
                      localcandidate: "local-candidate",
                      remotecandidate: "remote-candidate",
                    },
                    i = RTCPeerConnection.prototype.getStats;
                  RTCPeerConnection.prototype.getStats = function (e, a, o) {
                    return i
                      .apply(this, [e || null])
                      .then(function (e) {
                        if (
                          (n.version < 48 && (e = t(e)), n.version < 53 && !a)
                        )
                          try {
                            e.forEach(function (e) {
                              e.type = r[e.type] || e.type;
                            });
                          } catch (t) {
                            if ("TypeError" !== t.name) throw t;
                            e.forEach(function (t, n) {
                              e.set(
                                n,
                                Object.assign({}, t, {
                                  type: r[t.type] || t.type,
                                })
                              );
                            });
                          }
                        return e;
                      })
                      .then(a, o);
                  };
                }
              },
            };
          t.exports = {
            shimOnTrack: i.shimOnTrack,
            shimSourceObject: i.shimSourceObject,
            shimPeerConnection: i.shimPeerConnection,
            shimGetUserMedia: e("./getusermedia"),
          };
        },
        { "../utils": 11, "./getusermedia": 9 },
      ],
      9: [
        function (e, t, r) {
          "use strict";
          var n = e("../utils").log,
            i = e("../utils").browserDetails;
          t.exports = function () {
            var e = function (e) {
                return {
                  name:
                    {
                      NotSupportedError: "TypeError",
                      SecurityError: "NotAllowedError",
                      PermissionDeniedError: "NotAllowedError",
                    }[e.name] || e.name,
                  message:
                    {
                      "The operation is insecure.":
                        "The request is not allowed by the user agent or the platform in the current context.",
                    }[e.message] || e.message,
                  constraint: e.constraint,
                  toString: function () {
                    return this.name + (this.message && ": ") + this.message;
                  },
                };
              },
              t = function (t, r, a) {
                var o = function (e) {
                  if ("object" != typeof e || e.require) return e;
                  var t = [];
                  return (
                    Object.keys(e).forEach(function (r) {
                      if (
                        "require" !== r &&
                        "advanced" !== r &&
                        "mediaSource" !== r
                      ) {
                        var n = (e[r] =
                          "object" == typeof e[r] ? e[r] : { ideal: e[r] });
                        if (
                          ((void 0 === n.min &&
                            void 0 === n.max &&
                            void 0 === n.exact) ||
                            t.push(r),
                          void 0 !== n.exact &&
                            ("number" == typeof n.exact
                              ? (n.min = n.max = n.exact)
                              : (e[r] = n.exact),
                            delete n.exact),
                          void 0 !== n.ideal)
                        ) {
                          e.advanced = e.advanced || [];
                          var i = {};
                          "number" == typeof n.ideal
                            ? (i[r] = { min: n.ideal, max: n.ideal })
                            : (i[r] = n.ideal),
                            e.advanced.push(i),
                            delete n.ideal,
                            Object.keys(n).length || delete e[r];
                        }
                      }
                    }),
                    t.length && (e.require = t),
                    e
                  );
                };
                return (
                  (t = JSON.parse(JSON.stringify(t))),
                  i.version < 38 &&
                    (n("spec: " + JSON.stringify(t)),
                    t.audio && (t.audio = o(t.audio)),
                    t.video && (t.video = o(t.video)),
                    n("ff37: " + JSON.stringify(t))),
                  navigator.mozGetUserMedia(t, r, function (t) {
                    a(e(t));
                  })
                );
              },
              r = function (e) {
                return new Promise(function (r, n) {
                  t(e, r, n);
                });
              };
            if (
              (navigator.mediaDevices ||
                (navigator.mediaDevices = {
                  getUserMedia: r,
                  addEventListener: function () {},
                  removeEventListener: function () {},
                }),
              (navigator.mediaDevices.enumerateDevices =
                navigator.mediaDevices.enumerateDevices ||
                function () {
                  return new Promise(function (e) {
                    e([
                      {
                        kind: "audioinput",
                        deviceId: "default",
                        label: "",
                        groupId: "",
                      },
                      {
                        kind: "videoinput",
                        deviceId: "default",
                        label: "",
                        groupId: "",
                      },
                    ]);
                  });
                }),
              i.version < 41)
            ) {
              var a = navigator.mediaDevices.enumerateDevices.bind(
                navigator.mediaDevices
              );
              navigator.mediaDevices.enumerateDevices = function () {
                return a().then(void 0, function (e) {
                  if ("NotFoundError" === e.name) return [];
                  throw e;
                });
              };
            }
            if (i.version < 49) {
              var o = navigator.mediaDevices.getUserMedia.bind(
                navigator.mediaDevices
              );
              navigator.mediaDevices.getUserMedia = function (t) {
                return o(t).then(
                  function (e) {
                    if (
                      (t.audio && !e.getAudioTracks().length) ||
                      (t.video && !e.getVideoTracks().length)
                    )
                      throw (
                        (e.getTracks().forEach(function (e) {
                          e.stop();
                        }),
                        new DOMException(
                          "The object can not be found here.",
                          "NotFoundError"
                        ))
                      );
                    return e;
                  },
                  function (t) {
                    return Promise.reject(e(t));
                  }
                );
              };
            }
            navigator.getUserMedia = function (e, r, n) {
              if (i.version < 44) return t(e, r, n);
              console.warn(
                "navigator.getUserMedia has been replaced by navigator.mediaDevices.getUserMedia"
              ),
                navigator.mediaDevices.getUserMedia(e).then(r, n);
            };
          };
        },
        { "../utils": 11 },
      ],
      10: [
        function (e, t, r) {
          "use strict";
          var n = {
            shimOnAddStream: function () {
              "object" != typeof window ||
                !window.RTCPeerConnection ||
                "onaddstream" in window.RTCPeerConnection.prototype ||
                Object.defineProperty(
                  window.RTCPeerConnection.prototype,
                  "onaddstream",
                  {
                    get: function () {
                      return this._onaddstream;
                    },
                    set: function (e) {
                      this._onaddstream &&
                        (this.removeEventListener(
                          "addstream",
                          this._onaddstream
                        ),
                        this.removeEventListener(
                          "track",
                          this._onaddstreampoly
                        )),
                        this.addEventListener(
                          "addstream",
                          (this._onaddstream = e)
                        ),
                        this.addEventListener(
                          "track",
                          (this._onaddstreampoly = function (e) {
                            var t = e.streams[0];
                            if (
                              (this._streams || (this._streams = []),
                              !(this._streams.indexOf(t) >= 0))
                            ) {
                              this._streams.push(t);
                              var r = new Event("addstream");
                              (r.stream = e.streams[0]), this.dispatchEvent(r);
                            }
                          }.bind(this))
                        );
                    },
                  }
                );
            },
            shimGetUserMedia: function () {
              navigator.getUserMedia ||
                (navigator.webkitGetUserMedia
                  ? (navigator.getUserMedia =
                      navigator.webkitGetUserMedia.bind(navigator))
                  : navigator.mediaDevices &&
                    navigator.mediaDevices.getUserMedia &&
                    (navigator.getUserMedia = function (e, t, r) {
                      navigator.mediaDevices.getUserMedia(e).then(t, r);
                    }.bind(navigator)));
            },
          };
          t.exports = {
            shimOnAddStream: n.shimOnAddStream,
            shimGetUserMedia: n.shimGetUserMedia,
          };
        },
        {},
      ],
      11: [
        function (e, t, r) {
          "use strict";
          var n = !0,
            i = {
              disableLog: function (e) {
                return "boolean" != typeof e
                  ? new Error(
                      "Argument type: " + typeof e + ". Please use a boolean."
                    )
                  : ((n = e),
                    e
                      ? "adapter.js logging disabled"
                      : "adapter.js logging enabled");
              },
              log: function () {
                if ("object" == typeof window) {
                  if (n) return;
                  "undefined" != typeof console &&
                    "function" == typeof console.log &&
                    console.log.apply(console, arguments);
                }
              },
              extractVersion: function (e, t, r) {
                var n = e.match(t);
                return n && n.length >= r && parseInt(n[r], 10);
              },
              detectBrowser: function () {
                var e = {};
                if (
                  ((e.browser = null),
                  (e.version = null),
                  "undefined" == typeof window || !window.navigator)
                )
                  return (e.browser = "Not a browser."), e;
                if (navigator.mozGetUserMedia)
                  (e.browser = "firefox"),
                    (e.version = this.extractVersion(
                      navigator.userAgent,
                      /Firefox\/(\d+)\./,
                      1
                    ));
                else if (navigator.webkitGetUserMedia)
                  if (window.webkitRTCPeerConnection)
                    (e.browser = "chrome"),
                      (e.version = this.extractVersion(
                        navigator.userAgent,
                        /Chrom(e|ium)\/(\d+)\./,
                        2
                      ));
                  else {
                    if (!navigator.userAgent.match(/Version\/(\d+).(\d+)/))
                      return (
                        (e.browser =
                          "Unsupported webkit-based browser with GUM support but no WebRTC support."),
                        e
                      );
                    (e.browser = "safari"),
                      (e.version = this.extractVersion(
                        navigator.userAgent,
                        /AppleWebKit\/(\d+)\./,
                        1
                      ));
                  }
                else if (
                  navigator.mediaDevices &&
                  navigator.userAgent.match(/Edge\/(\d+).(\d+)$/)
                )
                  (e.browser = "edge"),
                    (e.version = this.extractVersion(
                      navigator.userAgent,
                      /Edge\/(\d+).(\d+)$/,
                      2
                    ));
                else {
                  if (
                    !navigator.mediaDevices ||
                    !navigator.userAgent.match(/AppleWebKit\/(\d+)\./)
                  )
                    return (e.browser = "Not a supported browser."), e;
                  (e.browser = "safari"),
                    (e.version = this.extractVersion(
                      navigator.userAgent,
                      /AppleWebKit\/(\d+)\./,
                      1
                    ));
                }
                return e;
              },
              shimCreateObjectURL: function () {
                if (
                  "object" == typeof window &&
                  window.HTMLMediaElement &&
                  "srcObject" in window.HTMLMediaElement.prototype
                ) {
                  var e = URL.createObjectURL.bind(URL),
                    t = URL.revokeObjectURL.bind(URL),
                    r = new Map(),
                    n = 0;
                  (URL.createObjectURL = function (t) {
                    if ("getTracks" in t) {
                      var i = "polyblob:" + ++n;
                      return (
                        r.set(i, t),
                        console.log(
                          "URL.createObjectURL(stream) is deprecated! Use elem.srcObject = stream instead!"
                        ),
                        i
                      );
                    }
                    return e(t);
                  }),
                    (URL.revokeObjectURL = function (e) {
                      t(e), r.delete(e);
                    });
                  var i = Object.getOwnPropertyDescriptor(
                    window.HTMLMediaElement.prototype,
                    "src"
                  );
                  Object.defineProperty(
                    window.HTMLMediaElement.prototype,
                    "src",
                    {
                      get: function () {
                        return i.get.apply(this);
                      },
                      set: function (e) {
                        return (
                          (this.srcObject = r.get(e) || null),
                          i.set.apply(this, [e])
                        );
                      },
                    }
                  );
                  var a = HTMLMediaElement.prototype.setAttribute;
                  HTMLMediaElement.prototype.setAttribute = function () {
                    return (
                      2 === arguments.length &&
                        "src" === ("" + arguments[0]).toLowerCase() &&
                        (this.srcObject = r.get(arguments[1]) || null),
                      a.apply(this, arguments)
                    );
                  };
                }
              },
            };
          t.exports = {
            log: i.log,
            disableLog: i.disableLog,
            browserDetails: i.detectBrowser(),
            extractVersion: i.extractVersion,
            shimCreateObjectURL: i.shimCreateObjectURL,
            detectBrowser: i.detectBrowser.bind(i),
          };
        },
        {},
      ],
    },
    {},
    [2]
  )(2);
});
//# sourceMappingURL=adapter.min.js.map

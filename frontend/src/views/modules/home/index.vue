<template>
  <v-container fluid>
    <v-row>
      <v-col cols="12" sm="6" md="4" lg="3" xl="2">
        <v-card>
          <v-card-title>新增用户</v-card-title>
          <v-card-text>600</v-card-text>
        </v-card>
      </v-col>
      <v-col cols="12" sm="6" md="4" lg="3" xl="2">
        <v-card>
          <v-card-title>活跃用户</v-card-title>
          <v-card-text>9527</v-card-text>
        </v-card>
      </v-col>
      <v-col cols="12" sm="6" md="4" lg="3" xl="2">
        <v-card>
          <v-card-title>访问量</v-card-title>
          <v-card-text>12345</v-card-text>
        </v-card>
      </v-col>
      <v-col cols="12" sm="6" md="4" lg="3" xl="2">
        <v-card>
          <v-card-title>销售额</v-card-title>
          <v-card-text>54321</v-card-text>
        </v-card>
      </v-col>
      <v-col cols="12" sm="6" md="4" lg="3" xl="2">
        <v-card>
          <v-card-title>销售额</v-card-title>
          <v-card-text>54321</v-card-text>
        </v-card>
      </v-col>
      <v-col cols="12" sm="6" md="4" lg="3" xl="2">
        <v-card>
          <v-card-title>销售额</v-card-title>
          <v-card-text>54321</v-card-text>
        </v-card>
      </v-col>
    </v-row>
    <v-subheader>echarts</v-subheader>
    <v-row>
      <v-col cols="12" lg="6">
        <v-card>
          <v-card-text>
            <div id="chartLineBox" class="ma-0 chartBox"></div>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="12" lg="6">
        <v-card>
          <v-card-text>
            <div id="chartPieBox" class="chartBox"></div>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="12" lg="6">
        <v-card>
          <v-card-text>
            <div id="chartGaugeBox" class="chartBox"></div>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
import echarts from "../../../plugins/echarts";

export default {
  data() {
    return {
      chartLine: null,
      chartPie: null,
      chartGauge: null
    };
  },
  mounted() {
    this.initChartPie();
    this.initChartLine();
    this.initChartGuage();
    window.addEventListener("resize", this.onResize);
    this.$once("hook:beforeDestroy", () => {
      window.removeEventListener("resize", this.onResize);
    });
    setTimeout(() => {
      this.onResize();
    }, 0);
  },
  methods: {
    onResize() {
      this.chartLine && this.chartLine.resize();
      this.chartPie && this.chartPie.resize();
      this.chartGauge && this.chartGauge.resize();
    },
    initChartLine() {
      let option = {
        title: {
          text: "折线图堆叠"
        },
        tooltip: {
          trigger: "axis"
        },
        legend: {
          data: ["邮件营销", "联盟广告", "视频广告", "直接访问", "搜索引擎"]
        },
        grid: {
          left: "3%",
          right: "4%",
          bottom: "3%",
          containLabel: true
        },
        toolbox: {
          feature: {
            saveAsImage: {}
          }
        },
        xAxis: {
          type: "category",
          boundaryGap: false,
          data: ["周一", "周二", "周三", "周四", "周五", "周六", "周日"]
        },
        yAxis: {
          type: "value"
        },
        series: [
          {
            name: "邮件营销",
            type: "line",
            stack: "总量",
            data: [120, 132, 101, 134, 90, 230, 210]
          },
          {
            name: "联盟广告",
            type: "line",
            stack: "总量",
            data: [220, 182, 191, 234, 290, 330, 310]
          },
          {
            name: "视频广告",
            type: "line",
            stack: "总量",
            data: [150, 232, 201, 154, 190, 330, 410]
          },
          {
            name: "直接访问",
            type: "line",
            stack: "总量",
            data: [320, 332, 301, 334, 390, 330, 320]
          },
          {
            name: "搜索引擎",
            type: "line",
            stack: "总量",
            data: [820, 932, 901, 934, 1290, 1330, 1320]
          }
        ]
      };
      this.chartLine = echarts.init(document.getElementById("chartLineBox"));
      this.chartLine.setOption(option);
    },
    initChartPie() {
      let option = {
        backgroundColor: "#2c343c",

        title: {
          text: "Customized Pie",
          left: "center",
          top: 20,
          textStyle: {
            color: "#ccc"
          }
        },

        tooltip: {
          trigger: "item",
          formatter: "{a} <br/>{b} : {c} ({d}%)"
        },

        visualMap: {
          show: false,
          min: 80,
          max: 600,
          inRange: {
            colorLightness: [0, 1]
          }
        },
        series: [
          {
            name: "访问来源",
            type: "pie",
            radius: "55%",
            center: ["50%", "50%"],
            data: [
              { value: 335, name: "直接访问" },
              { value: 310, name: "邮件营销" },
              { value: 274, name: "联盟广告" },
              { value: 235, name: "视频广告" },
              { value: 400, name: "搜索引擎" }
            ].sort(function(a, b) {
              return a.value - b.value;
            }),
            roseType: "radius",
            label: {
              color: "rgba(255, 255, 255, 0.3)"
            },
            labelLine: {
              lineStyle: {
                color: "rgba(255, 255, 255, 0.3)"
              },
              smooth: 0.2,
              length: 10,
              length2: 20
            },
            itemStyle: {
              color: "#c23531",
              shadowBlur: 200,
              shadowColor: "rgba(0, 0, 0, 0.5)"
            },

            animationType: "scale",
            animationEasing: "elasticOut",
            animationDelay: function() {
              return Math.random() * 200;
            }
          }
        ]
      };
      this.chartPie = echarts.init(document.getElementById("chartPieBox"));
      this.chartPie.setOption(option);
    },
    initChartGuage() {
      let option = {
        title: {
          text: "仪表盘"
        },
        tooltip: {
          formatter: "{a} <br/>{b} : {c}%"
        },
        toolbox: {
          feature: {
            restore: {},
            saveAsImage: {}
          }
        },
        series: [
          {
            name: "业务指标",
            type: "gauge",
            detail: { formatter: "{value}%" },
            data: [{ value: 50, name: "完成率" }]
          }
        ]
      };
      this.chartGauge = echarts.init(document.getElementById("chartGaugeBox"));
      this.chartGauge.setOption(option);
      const gaugeTimer = setInterval(() => {
        option.series[0].data[0].value = (Math.random() * 100).toFixed(2) - 0;
        this.chartGauge.setOption(option, true);
      }, 2000);
      this.$once("hook:beforeDestroy", () => {
        clearInterval(gaugeTimer);
      });
    }
  }
};
</script>
<style>
.chartBox {
  min-height: 300px;
}
</style>